<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\QueryAction;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;

class GetCurrentTenantAction implements QueryAction
{
    use Invocable;

    public function handle(): Tenant
    {
        $tenant = Tenant::current();

        if (null === $tenant) {
            throw NotFoundTenantException::notSet();
        }

        return $tenant;
    }
}
