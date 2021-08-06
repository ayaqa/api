<?php

namespace AyaQA\Core\Exceptions;

use AyaQA\Core\Exceptions\Base\APIException;
use AyaQA\Core\Exceptions\Contract\ProvidesFriendlyMessage;
use AyaQA\Core\Exceptions\Contract\ProvidesStatusCode;
use Illuminate\Http\Response;
use Throwable;

class UnauthorizedRequestException extends APIException implements ProvidesFriendlyMessage, ProvidesStatusCode
{
    private string $publicMessage;

    /**
     * @param string $friendlyMessage
     * @param Throwable|null $throwable
     *
     * @return static
     */
    public static function withMessage(string $friendlyMessage, ?Throwable $throwable = null)
    {
        $self = new static($friendlyMessage, 0, $throwable);
        $self->publicMessage = $friendlyMessage;

        return $self;
    }

    public function getFriendlyMessage(): string
    {
        return $this->publicMessage;
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
