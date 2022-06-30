<?php

namespace AyaQA\Support\Bug\Action\Contract;

use AyaQA\Support\Bug\Action\Enum\When;

interface BugAction
{
    public function exec(array $context): bool;
    public function when(): When;
}
