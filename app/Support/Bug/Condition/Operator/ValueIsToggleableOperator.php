<?php

namespace AyaQA\Support\Bug\Condition\Operator;

use AyaQA\Support\Bug\Condition\ConditionConfig;
use AyaQA\Support\Bug\Condition\Contract\ConditionOperator;
use AyaQA\Support\Bug\Support\Utility\CompareHelper;
use AyaQA\Support\Bug\Value\Contract\BugKeyValue;
use AyaQA\Support\Bug\Value\Contract\BugValue;

class ValueIsToggleableOperator implements ConditionOperator
{
    public function compare(ConditionConfig $config, BugValue $value): bool
    {
        if ($value instanceof BugKeyValue) {
            $configAsValue = $config->asValue();

            if ($configAsValue->sameKeyAs($value)) {
                return CompareHelper::isBool($value->value());
            }
        }

        return false;
    }
}
