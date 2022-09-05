<?php

namespace AyaQA\Support\BugFramework\Condition\Operator\Type;

use AyaQA\Support\BugFramework\Condition\Contract\ConditionOperator;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

class ValueIsToggleableOperator implements ConditionOperator
{
    public function compare(Config $config, BugValue $value): bool
    {
        if ($config->asValue()->sameKeyAs($value)) {
            return is_bool($value->value());
        }

        return false;
    }
}
