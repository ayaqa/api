<?php

namespace AyaQA\Support\BugFramework\Context\Event;

use AyaQA\Support\BugFramework\Value\ValueType;

class SetContextValue
{
    public function __construct(
        public readonly ValueType $type,
        public readonly array $data,
        public readonly bool $overrideIfSet = false)
    {
    }

    public static function from(ValueType $type, array $data, bool $overrideIfSet = false): self
    {
        return new self($type, $data, $overrideIfSet);
    }
}
