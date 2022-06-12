<?php

namespace AyaQA\Support\BugFramework\Contract;

interface BugCondition
{
    public function compare(BugValue $value): bool;
}
