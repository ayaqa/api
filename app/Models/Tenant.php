<?php

namespace App\Models;

use App\Contracts\DatabaseManager;
use \Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    protected static function booted()
    {
        static::creating(fn(Tenant $model) => $model->createDatabase());
    }

    protected function createDatabase()
    {
        // @TODO make it with event and dispatch it from here.
        app()->make(DatabaseManager::class)->createDatabase($this);
    }
}
