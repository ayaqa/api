<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\InvocableAction;
use AyaQA\Contracts\Action;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;

class GetTenantAction implements Action
{
    use InvocableAction;

    public function handle(string $identifier)
    {
        return Tenant::query()->byIdentifier($identifier)->firstOr(['*'], function () {
            throw NotFoundTenantException::notFound();
        });
    }
}
