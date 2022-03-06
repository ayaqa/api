<?php

namespace AyaQA\Models\Core;

use AyaQA\Events\Core\TenantCreated;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    protected static function booted()
    {
        static::created(fn(Tenant $model) => TenantCreated::dispatch($model));
    }
}
