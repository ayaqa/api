<?php

namespace AyaQA\Support\BugFramework\Condition\Operators;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\Concern\DefaultOperator;
use AyaQA\Support\BugFramework\Condition\Contract\BugOperator;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

class NotOperator implements BugOperator
{
    use DefaultOperator;

    public function __construct(
        private BugOperator $parentCondition
    ) {}

    public function evaluate(BugField $value): bool
    {
        return false === $this->parentCondition->evaluate($value);
    }

    public function getTarget(): BugTarget
    {
        return $this->parentCondition->getTarget();
    }
}
