<?php

namespace AyaQA\Support\BugFramework\Condition\Concern;

use AyaQA\Support\BugFramework\Contract\BugCondition;

trait WrappedCondition
{
    public function __construct(
        private BugCondition $parentCondition
    ) {}
}
