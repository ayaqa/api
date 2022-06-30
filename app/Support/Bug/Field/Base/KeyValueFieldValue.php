<?php

namespace AyaQA\Support\Bug\Field\Base;

use AyaQA\Support\Bug\Field\Concern\ComparableFieldValue;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

abstract class KeyValueFieldValue implements BugFieldValue
{
    use ComparableFieldValue {
        sameValueAs as compareValue;
    }

    public function __construct(
        private string $key,
        private int|string|bool $value
    ) {}

    public function value(): string|int|bool
    {
        return $this->value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function sameValueAs(BugFieldValue $value): bool
    {
        if ($value instanceof KeyValueFieldValue) {
            return $this->compareValue($value) && $this->sameKeyAs($value);
        }

        return false;
    }

    public function sameKeyAs(BugFieldValue $value): bool
    {
        if ($value instanceof KeyValueFieldValue) {
            return $this->key() === $value->key();
        }

        return false;
    }
}
