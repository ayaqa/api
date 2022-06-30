<?php

namespace AyaQA\Support\BugFramework\Condition\Concern;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

trait DefaultOperator
{
    public function __construct(
        private BugTarget $target,
        private BugField $bugValue
    ) {}

    public function value(): BugField
    {
        return $this->bugValue;
    }

    public function getTarget(): BugTarget
    {
        return $this->target;
    }
}
