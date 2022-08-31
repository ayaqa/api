<?php

namespace AyaQA\Support\Bug\Event;

use AyaQA\Support\Bug\Value\BugValueType;

class NewContextValue
{
    public function __construct(
        public readonly BugValueType $type,
        public readonly array $data,
        public readonly bool $overrideIfSet = false)
    {
    }

    public static function from(BugValueType $type, array $data, bool $overrideIfSet = false): self
    {
        return new self($type, $data, $overrideIfSet);
    }
}
