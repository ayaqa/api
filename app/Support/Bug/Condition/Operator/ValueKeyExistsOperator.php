<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\ConditionConfig;
use AyaQA\Support\Bug\Condition\Contract\ConditionOperator;
use AyaQA\Support\Bug\Support\Utility\CompareHelper;
use AyaQA\Support\Bug\Value\Contract\BugValue;

class ValueKeyExistsOperator implements ConditionOperator
{
    public function compare(ConditionConfig $config, BugValue $value): bool
    {
        return $config->asValue()->sameKeyAs($value);
    }
}
