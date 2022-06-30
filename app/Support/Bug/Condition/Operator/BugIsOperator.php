<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\Concern\DefaultOperator;
use AyaQA\Support\Bug\Condition\Contract\BugConditionOperator;

class BugIsOperator implements BugConditionOperator
{
    use DefaultOperator;

    public function compare(int|string|null $value = null): bool
    {
        return $this->conditionValue->value() === $value;
    }
}
