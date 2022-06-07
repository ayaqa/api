<?php

namespace AyaQA\Models\Core;

use AyaQA\Enum\Core\TenantState;
use AyaQA\Events\Core\TenantCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

/**
 * AyaQA\Models\Core\Tenant
 *
 * @property int $id
 * @property string $session
 * @property string $database
 * @property TenantState $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Spatie\Multitenancy\TenantCollection|static[] all($columns = ['*'])
 * @method static \Spatie\Multitenancy\TenantCollection|static[] get($columns = ['*'])
 * @method static Builder|Tenant newModelQuery()
 * @method static Builder|Tenant newQuery()
 * @method static Builder|Tenant query()
 * @method static Builder|Tenant whereCreatedAt($value)
 * @method static Builder|Tenant whereDatabase($value)
 * @method static Builder|Tenant whereId($value)
 * @method static Builder|Tenant whereSession($value)
 * @method static Builder|Tenant whereState($value)
 * @method static Builder|Tenant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|Tenant onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tenant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tenant withoutTrashed()
 * @property bool $deletable
 * @property \Carbon\CarbonImmutable|null $requested_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|Tenant byIdentifier(string $identifier)
 * @method static Builder|Tenant whereDeletable($value)
 * @method static Builder|Tenant whereDeletedAt($value)
 * @method static Builder|Tenant whereRequestedAt($value)
 * @method static Builder|Tenant active(bool $withDeleted = false)
 * @method static Builder|Tenant sessions(bool $withDeleted = false)
 * @method static Builder|Tenant forAutoDelete(int $timeSinceLastRequestInSeconds)
 */
class Tenant extends SpatieTenant
{
    use SoftDeletes;

    protected $fillable = ['database', 'session', 'state', 'deletable'];
    protected $hidden = ['database', 'requested_at', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'state' => TenantState::class,
        'requested_at' => 'immutable_datetime',
        'deletable' => 'boolean'
    ];

    public function setState(TenantState $state): self
    {
        $this->state = $state;
        $this->save();

        return $this;
    }

    /**
     * @param Builder  $query
     * @param string $identifier
     *
     * @return Builder
     */
    public function scopeByIdentifier($query, string $identifier): Builder
    {
        return $query
            ->where('state', '!=', TenantState::DELETING)
            ->where(function(Builder $query) use ($identifier) {
                $query
                    ->where('id', '=', $identifier)
                    ->orWhere('session', '=', $identifier);
            });
    }

    /**
     * @param Builder $query
     * @param bool    $withDeleted
     *
     * @return Builder
     */
    public function scopeSessions($query, bool $withDeleted = false): Builder
    {
        $query->when($withDeleted, function(Builder $q) {
            $q->orWhereNotNull('deleted_at');
        }, function(Builder $q) {
            $q->where('state', '!=', TenantState::DELETING);
        });

        return $query;
    }

    /**
     * @param Builder $query
     * @param int $timeSinceLastRequestInSeconds
     *
     * @return Builder
     */
    public function scopeForAutoDelete($query, int $timeSinceLastRequestInSeconds): Builder
    {
        $dateTime = Date::now('UTC')->subSeconds($timeSinceLastRequestInSeconds)->toDateTimeString();

        $this->scopeSessions($query, false)
            ->where('deletable', '=', 1)
            ->where(function (Builder $query) use ($dateTime) {
                $query->where('created_at', '<=', $dateTime);
                $query->whereNull('requested_at');
            })
            ->orWhere('requested_at', '<=', $dateTime);

        return $query;
    }

    protected static function booted()
    {
        static::created(fn(Tenant $model) => TenantCreated::dispatch($model));
    }
}
