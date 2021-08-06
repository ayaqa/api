<?php

namespace AyaQA\Core\Exceptions\Contract;

interface ProvidesStatusCode
{
    public function getStatusCode(): int;
}
