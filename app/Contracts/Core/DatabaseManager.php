<?php

namespace AyaQA\Contracts\Core;

use Spatie\Multitenancy\Models\Tenant;

/**
 * Default database interface that will take care of different connection types
 */
interface DatabaseManager
{
    public function createDatabase(Tenant $tenant): bool;
    public function deleteDatabase(Tenant $tenant): bool;
    public function exists(Tenant $tenant): bool;
}
