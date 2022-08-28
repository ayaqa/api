<?php

namespace AyaQA\Support\Bug\Manifest\Bug;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\Enum\ConfigurableStep;

class HideUIElementBug implements Bug
{
    public function getId(): string
    {
        return BugMapper::getBugId(self::class);
    }

    public function getText(): string
    {
        return 'Hide UI Element';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::APP;
    }

    public function configurable(): ConfigurableStep
    {
        return ConfigurableStep::WITH_UI_ELEMENT_KEY;
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysCondition::class
        ];
    }
}
