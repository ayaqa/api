<?php

namespace AyaQA\Support\BugFramework\Value;

use AyaQA\Support\Bug\Field\Concern\ComparableFieldValue;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

class Parameter implements BugFieldValue
{
    use ComparableFieldValue {
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

    public function sameValueAs(BugFieldValue $value): bool
    {
        if ($value instanceof Parameter) {
            return $this->compareValue($value)
                && $this->getName() === $value->getName();
        }

        return false;
    }
}
