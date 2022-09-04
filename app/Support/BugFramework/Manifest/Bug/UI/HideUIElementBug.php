<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\UI;

use AyaQA\Support\BugFramework\Bug\BugMapper;
use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\Bug;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class HideUIElementBug implements Bug
{
    public function getId(): string
    {
        return BugType::HIDE_UI_ELEMENT->getId();
    }

    public function getText(): string
    {
        return 'Hide UI Element';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::APP;
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::WITH_UI_ELEMENT_KEY;
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysCondition::class
        ];
    }
}
