<?php

namespace AyaQA\Exceptions\Core;

use AyaQA\Concerns\ProvidesResponseCode;
use AyaQA\Contracts\Core\Exception\HasResponseCode;
use Symfony\Component\HttpFoundation\Response;

class NotFoundTenantException extends TenantException implements HasResponseCode
{
    use ProvidesResponseCode;

    public static function notSet(): static
    {
        return (new static(__('errors.tenant_not_set')))
            ->setHttpCode(Response::HTTP_NOT_FOUND);
    }

    public static function notFound(): static
    {
        return (new static(__('errors.tenant_by_id_not_found')))
            ->setHttpCode(Response::HTTP_NOT_FOUND);
    }
}
