<?php

namespace AyaQA\Support\BugFramework\Condition\Operator\Type;

use function mb_strtolower;
use AyaQA\Support\BugFramework\Condition\Contract\ConditionOperator;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Support\Utility\CompareHelper;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

class ValueIsEqualOperator implements ConditionOperator
{
    public function compare(Config $config, BugValue $value): bool
    {
        if (CompareHelper::isBool($value->value()) && CompareHelper::isBool($config->getValue())) {
            $boolValueOne = CompareHelper::toBool($value->value());
            $boolValueTwo = CompareHelper::toBool($config->getValue());

            return $boolValueOne === $boolValueTwo;
        }

        return mb_strtolower($value->value()) == mb_strtolower($config->getValue());
    }
}
