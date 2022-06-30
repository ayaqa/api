<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\Contract\BugConditionOperator;

class BugIsEmptyOperator implements BugConditionOperator
{
    public function compare(int|string|null $value = null): bool
    {
        return empty($value);
    }

    public function notComparedResult(): bool
    {
        return true;
    }
}
