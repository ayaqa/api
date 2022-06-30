<?php

namespace AyaQA\Support\BugFramework\Condition\Contract;

use AyaQA\Support\BugFramework\Value\Contract\BugField;
use AyaQA\Support\BugFramework\Value\Contract\BugFieldCollection;

interface BugCondition
{
    public function getTargets(): array;
    public function evaluate(BugField $value): bool;
    public function evaluateCollection(BugFieldCollection $collection): bool;
}
