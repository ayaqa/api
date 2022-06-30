<?php

namespace AyaQA\Support\Bug\Condition\Value;

use AyaQA\Support\Bug\Condition\Contract\BugConditionOperatorValue;

class BugLiteralOperatorValue implements BugConditionOperatorValue
{
    public function __construct(
        private int|string|null $value = null,
    ) {}

    public function value(): string|int|null
    {
        return $this->value;
    }
}
