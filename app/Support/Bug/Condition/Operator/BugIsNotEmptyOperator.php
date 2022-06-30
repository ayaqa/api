<?php

namespace AyaQA\Support\Bug\Condition\Operator;

class BugIsNotEmptyOperator extends BugIsEmptyOperator
{
    public function compare(int|string|null $value = null): bool
    {
        return false === parent::compare($value);
    }

    public function notComparedResult(): bool
    {
        return false;
    }
}
