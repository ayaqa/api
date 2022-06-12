<?php

namespace AyaQA\Support\BugFramework\Condition\Concern;

use AyaQA\Support\BugFramework\Contract\BugValue;

trait DefaultCondition
{
    public function __construct(
        private BugValue $bugValue
    ) {}
}
