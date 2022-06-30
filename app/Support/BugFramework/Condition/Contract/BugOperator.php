<?php

namespace AyaQA\Support\BugFramework\Condition\Contract;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

interface BugOperator
{
    public function evaluate(BugField $value): bool;
    public function value(): BugField;
    public function getTarget(): BugTarget;
}
