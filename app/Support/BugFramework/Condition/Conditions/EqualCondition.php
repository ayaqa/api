<?php

namespace AyaQA\Support\BugFramework\Condition\Conditions;

use AyaQA\Support\BugFramework\Condition\Concern\DefaultCondition;
use AyaQA\Support\BugFramework\Contract\BugCondition;
use AyaQA\Support\BugFramework\Contract\BugValue;

class EqualCondition implements BugCondition
{
    use DefaultCondition;

    public function compare(BugValue $value): bool
    {
        return $this->bugValue->sameAs($value);
    }
}
