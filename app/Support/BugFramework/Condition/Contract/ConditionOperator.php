<?php

namespace AyaQA\Support\BugFramework\Condition\Contract;

use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

interface ConditionOperator
{
    public function compare(Config $config, BugValue $value): bool;
}
