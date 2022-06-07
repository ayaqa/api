<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\InvocableAction;
use AyaQA\Contracts\Action;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;

class GetCurrentTenant implements Action
{
    use InvocableAction;

    public function handle(): Tenant
    {
        $tenant = Tenant::current();

        if (null === $tenant) {
            throw NotFoundTenantException::notSet();
        }

        return $tenant;
    }
}
