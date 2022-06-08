<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\QueryAction;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;

class GetTenantAction implements QueryAction
{
    use Invocable;

    public function handle(string $identifier)
    {
        return Tenant::query()->byIdentifier($identifier)->firstOr(['*'], function () {
            throw NotFoundTenantException::notFound();
        });
    }
}
