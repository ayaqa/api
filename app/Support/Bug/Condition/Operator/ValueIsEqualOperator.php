<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\ConditionConfig;
use AyaQA\Support\Bug\Condition\Contract\ConditionOperator;
use AyaQA\Support\Bug\Support\Utility\CompareHelper;
use AyaQA\Support\Bug\Value\Contract\BugValue;

class ValueIsEqualOperator implements ConditionOperator
{
    public function compare(ConditionConfig $config, BugValue $value): bool
    {
        if (CompareHelper::isBool($value->value()) && CompareHelper::isBool($config->getValue())) {
            $boolValueOne = CompareHelper::toBool($value->value());
            $boolValueTwo = CompareHelper::toBool($config->getValue());

            return $boolValueOne === $boolValueTwo;
        }

        return mb_strtolower($value->value()) == mb_strtolower($config->getValue());
    }
}
