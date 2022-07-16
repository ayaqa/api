<?php

namespace AyaQA\Exceptions\Core;

use AyaQA\Exceptions\AyaQAException;

class TenantException extends AyaQAException
{
    public static function maxTenant(int $limit): static
    {
        return new static(__('errors.max_tenant_created', ['count' => $limit]));
    }

    public static function noPermission(): static
    {
        throw new static('Dont have permission do perform this operation.');
    }

    public static function noDriver(string $driver): static
    {
        throw new static(sprintf(
                'There is not driver implemented to work with %s db',
                $driver
            )
        );
    }
}
