<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\Concern\DefaultOperator;
use AyaQA\Support\Bug\Condition\Contract\BugConditionOperator;

class BugContainsOperator implements BugConditionOperator
{
    use DefaultOperator;

    public function compare(int|string|null $value = null): bool
    {
        $conditionValue = $this->conditionValue->value();
        if (is_string($value) && is_string($conditionValue)) {
            return str_contains($conditionValue, $value);
        }

        return false;
    }
}
