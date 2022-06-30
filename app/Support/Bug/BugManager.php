<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Condition\Resolver\ConditionResolver;
use AyaQA\Support\Bug\Context\BugContext;

class BugManager
{
    public function __construct(
        private BugContext $context,
        private ConditionResolver $resolver
    ) {}
}
