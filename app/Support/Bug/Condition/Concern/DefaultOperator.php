<?php

namespace AyaQA\Support\Bug\Condition\Concern;

use AyaQA\Support\Bug\Condition\Contract\BugConditionOperatorValue;

trait DefaultOperator
{
    public function __construct(private BugConditionOperatorValue $conditionValue)
    {
    }

    public function notComparedResult(): bool
    {
        return false;
    }
}
