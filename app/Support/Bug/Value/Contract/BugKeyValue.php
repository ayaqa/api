<?php

namespace AyaQA\Support\Bug\Value\Contract;

interface BugKeyValue extends BugValue
{
    public function key(): string;

    public function sameKeyAs(BugValue $value): bool;
}
