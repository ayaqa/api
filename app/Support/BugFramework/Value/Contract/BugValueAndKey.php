<?php

namespace AyaQA\Support\BugFramework\Value\Contract;

interface BugValueAndKey extends BugValue
{
    public function key(): string;

    public function sameKeyAs(BugValue $value): bool;
}
