<?php

namespace AyaQA\Support\BugFramework\Value;

use AyaQA\Support\BugFramework\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Concern\ComparableValue;

class Parameter implements BugValue
{
    use ComparableValue {
        sameValueAs as compareValue;
    }

    public function __construct(
        private string $name,
        private int|string|bool $value
    ) {}

    public function value(): string|int|bool
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function sameValueAs(BugValue $value): bool
    {
        if ($value instanceof Parameter) {
            return $this->compareValue($value)
                && $this->getName() === $value->getName();
        }

        return false;
    }
}
