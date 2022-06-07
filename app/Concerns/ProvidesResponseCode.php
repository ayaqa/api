<?php

namespace AyaQA\Concerns;

use Symfony\Component\HttpFoundation\Response;

trait ProvidesResponseCode
{
    private int $httpCode = Response::HTTP_BAD_REQUEST;

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function setHttpCode(int $responseCode): static
    {
        $this->httpCode = $responseCode;

        return $this;
    }
}
