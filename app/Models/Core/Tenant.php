<?php

namespace AyaQA\Models\Core;

use AyaQA\Builders\Core\TenantBuilder;
use AyaQA\Enum\Core\TenantState;
use AyaQA\Events\Core\TenantCreated;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

/**
 * AyaQA\Models\Core\Tenant
 *
 * @property int $id
 * @property string $session
 * @property string $database
 * @property TenantState $state
 * @property bool $deletable
 * @property \Carbon\CarbonImmutable|null $requested_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Spatie\Multitenancy\TenantCollection|static[] all($columns = ['*'])
 * @method static TenantBuilder|Tenant byIdentifier(string $identifier)
 * @method static TenantBuilder|Tenant dbExists(string $dbName)
 * @method static TenantBuilder|Tenant forAutoDelete(int $timeSinceLastRequestInSeconds)
 * @method static \Spatie\Multitenancy\TenantCollection|static[] get($columns = ['*'])
 * @method static TenantBuilder|Tenant newModelQuery()
 * @method static TenantBuilder|Tenant newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tenant onlyTrashed()
 * @method static TenantBuilder|Tenant query()
 * @method static TenantBuilder|Tenant sessionExists(string $sessionId)
 * @method static TenantBuilder|Tenant sessions(bool $withDeleted = false)
 * @method static TenantBuilder|Tenant whereCreatedAt($value)
 * @method static TenantBuilder|Tenant whereDatabase($value)
 * @method static TenantBuilder|Tenant whereDeletable($value)
 * @method static TenantBuilder|Tenant whereDeletedAt($value)
 * @method static TenantBuilder|Tenant whereId($value)
 * @method static TenantBuilder|Tenant whereRequestedAt($value)
 * @method static TenantBuilder|Tenant whereSession($value)
 * @method static TenantBuilder|Tenant whereState($value)
 * @method static TenantBuilder|Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Tenant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tenant withoutTrashed()
 * @mixin \Eloquent
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

    /**
     * @param $query
     *
     * @return TenantBuilder
     */
    public function newEloquentBuilder($query): TenantBuilder
    {
        return new TenantBuilder($query);
    }

    public function setState(TenantState $state): self
    {
        $this->state = $state;
        $this->save();

        return $this;
    }

    protected static function booted()
    {
        static::created(fn(Tenant $model) => TenantCreated::dispatch($model));
    }
}
