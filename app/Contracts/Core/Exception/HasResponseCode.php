<?php

namespace AyaQA\Contracts\Core\Exception;

interface HasResponseCode
{
    public function getHttpCode(): int;
}
