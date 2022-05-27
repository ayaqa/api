<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;

class GetCurrentTenant
{
    public function handle(): Tenant
    {
        $tenant = Tenant::current();

        if (null === $tenant) {
            throw new NotFoundTenantException('Tenant db is not set.');
        }

        return $tenant;
    }
}
