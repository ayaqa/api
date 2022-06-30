<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\Contract\BugNotOperator;

class BugIsNotOperator extends BugIsOperator implements BugNotOperator
{
    public function compare(int|string|null $value = null): bool
    {
        return false === parent::compare($value);
    }

    public function notComparedResult(): bool
    {
        return true;
    }
}
