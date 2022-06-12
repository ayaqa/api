<?php

namespace AyaQA\Support\BugFramework\Condition\Conditions;

use AyaQA\Support\BugFramework\Condition\Concern\WrappedCondition;
use AyaQA\Support\BugFramework\Contract\BugCondition;
use AyaQA\Support\BugFramework\Contract\BugValue;

class NotCondition implements BugCondition
{
    use WrappedCondition;

    public function compare(BugValue $value): bool
    {
        return false === $this->parentCondition->compare($value);
    }
}
