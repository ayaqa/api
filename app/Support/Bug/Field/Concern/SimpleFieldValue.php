<?php

namespace AyaQA\Support\Bug\Field\Concern;

trait SimpleFieldValue
{
    public function __construct(
        private string|int $value,
    ) {}

    public function value(): string|int
    {
        return $this->value;
    }
}
