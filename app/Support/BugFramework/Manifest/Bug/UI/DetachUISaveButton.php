<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\UI;

use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfUIParameterIsChangedTo;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifest;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class DetachUISaveButton implements BugManifest
{
    public function getId(): string
    {
        return BugType::UI_DETACH_SAVE->getId();
    }

    public function getText(): string
    {
        return 'Detach save button';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::APP;
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::NONE;
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysManifestCondition::class,
            IfUIParameterIsChangedTo::class
        ];
    }
}
