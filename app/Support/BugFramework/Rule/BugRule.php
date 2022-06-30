<?php

namespace AyaQA\Support\BugFramework\Rule;

use AyaQA\Support\BugFramework\Action\Contract\BugAction;
use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\Contract\BugCondition;

class BugRule
{
    public function __construct(
        private BugTarget    $target,
        private BugCondition $condition,
        private BugAction    $action
    ) {}

    public function getTarget(): BugTarget
    {
        return $this->target;
    }

    public function getCondition(): BugCondition
    {
        return $this->condition;
    }

    public function getAction(): BugAction
    {
        return $this->action;
    }
}
