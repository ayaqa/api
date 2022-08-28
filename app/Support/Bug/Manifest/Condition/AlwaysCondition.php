<?php

namespace AyaQA\Support\Bug\Manifest\Condition;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Enum\ConfigurableStep;

class AlwaysCondition implements BugCondition
{
    public function getId(): string
    {
        return BugMapper::getConditionId(self::class);
    }

    public function getText(): string
    {
        return 'Always';
    }

    public function configurable(): ConfigurableStep
    {
        return ConfigurableStep::NONE;
    }
}
