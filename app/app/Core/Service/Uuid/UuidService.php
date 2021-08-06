<?php

namespace AyaQA\Core\Service\Uuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidService
{
    /**
     * @return UuidInterface
     */
    public function generate(): UuidInterface
    {
        return Uuid::uuid4();
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public function isValid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}
