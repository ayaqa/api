<?php

namespace AyaQA\Support\BugFramework\Value\Contract;

interface BugKeyValue extends BugValue
{
    public function key(): string;

    public function sameKeyAs(BugValue $value): bool;
}
