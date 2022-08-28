<?php

namespace AyaQA\Support\Bug\Manifest\Condition;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ConfigurableStep;

class IfToggleableIsCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return BugMapper::getConditionId(self::class);
    }

    public function getText(): string
    {
        return 'If param is toggleable and equal to';
    }

    public function configurable(): ConfigurableStep
    {
        return ConfigurableStep::WITH_PARAMETERS;
    }

    public function getDescription(): string
    {
        return 'Bug will be applied if param is toggleable (true, false, 1, 0) and matching configured value';
    }
}
