<?php

namespace AyaQA\Support\Bug\Action;

use AyaQA\Support\Bug\Action\Contract\BugAction;
use AyaQA\Support\Bug\Action\Enum\When;

class ThrowErrorAction implements BugAction
{
    public function __construct(array $args)
    {
    }

    public function exec(array $context): bool
    {
    }

    public function when(): When
    {
    }
}
