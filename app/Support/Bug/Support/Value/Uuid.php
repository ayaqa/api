<?php

namespace AyaQA\Support\Bug\Support\Value;

use Illuminate\Support\Str;

class Uuid
{
    public function __construct(
        private string $uuid
    ) {}

    public static function create(): self
    {
        return new self(Str::uuid());
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
