<?php

namespace AyaQA\Support\BugFramework\Condition\Operator\Type;

use AyaQA\Support\BugFramework\Condition\Contract\ConditionOperator;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Support\Utility\CompareHelper;
use AyaQA\Support\BugFramework\Value\Contract\BugKeyValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

class ValueIsToggleableOperator implements ConditionOperator
{
    public function compare(Config $config, BugValue $value): bool
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
