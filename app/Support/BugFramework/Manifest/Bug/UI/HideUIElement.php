<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\UI;

use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifest;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class HideUIElement implements BugManifest
{
    public function getId(): string
    {
        return BugType::UI_HIDE_ELEMENT->getId();
    }

    public function getText(): string
    {
        return 'Hide interface element';
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
            AlwaysManifestCondition::class
        ];
    }
}
