<?php

namespace AyaQA\Models\Core;

use AyaQA\Events\Core\TenantCreated;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

/**
 * AyaQA\Models\Core\Tenant
 *
 * @property int $id
 * @property string $session
 * @property string $database
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Spatie\Multitenancy\TenantCollection|static[] all($columns = ['*'])
 * @method static \Spatie\Multitenancy\TenantCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tenant extends SpatieTenant
{
    protected static function booted()
    {
        static::created(fn(Tenant $model) => TenantCreated::dispatch($model));
    }
}
