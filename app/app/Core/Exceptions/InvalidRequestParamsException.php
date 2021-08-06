<?php

namespace AyaQA\Core\Exceptions;

use AyaQA\Core\Exceptions\Base\APIException;
use AyaQA\Core\Exceptions\Contract\ProvidesFriendlyMessage;
use AyaQA\Core\Exceptions\Contract\ProvidesStatusCode;
use Illuminate\Http\Response;

class InvalidRequestParamsException extends APIException implements ProvidesFriendlyMessage, ProvidesStatusCode
{
    public function getFriendlyMessage(): string
    {
        return __('Provided payload contains invalid data.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
