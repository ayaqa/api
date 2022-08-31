<?php

namespace AyaQA\Support\Bug\Condition\Contract;

use AyaQA\Support\Bug\Condition\ConditionConfig;
use AyaQA\Support\Bug\Value\Contract\BugValue;

interface ConditionOperator
{
    public function compare(ConditionConfig $config, BugValue $value): bool;
}
