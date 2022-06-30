<?php

namespace AyaQA\Support\Bug\Condition\Contract;

interface BugConditionOperator
{
    public function compare(int|string|null $value = null): bool;
    public function notComparedResult(): bool;
}
