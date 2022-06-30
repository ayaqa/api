<?php

namespace AyaQA\Support\BugFramework\Condition\Operators;

use AyaQA\Support\BugFramework\Condition\Concern\DefaultOperator;
use AyaQA\Support\BugFramework\Condition\Contract\BugOperator;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

class EqualOperator implements BugOperator
{
    use DefaultOperator;

    public function evaluate(BugField $value): bool
    {
        return $this->bugValue->sameAs($value);
    }
}
