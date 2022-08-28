<?php

namespace AyaQA\Support\Bug\Manifest\Bug;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfToggleableIsCondition;
use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\Enum\ConfigurableStep;

class ModifyRequestParameter implements Bug
{
    public function getId(): string
    {
        return BugMapper::getBugId(self::class);
    }

    public function getText(): string
    {
        return 'Modify request parameter';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::API;
    }

    public function configurable(): ConfigurableStep
    {
        return ConfigurableStep::WITH_PARAMETERS;
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysCondition::class,
            IfToggleableIsCondition::class
        ];
    }
}
