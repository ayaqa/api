<?php

namespace AyaQA\Support\BugFramework\Manifest\Condition;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ConfigType;

class IfUIParameterIsChangedTo implements BugManifestCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::IF_UI_PARAM_IS->getId();
    }

    public function getText(): string
    {
        return 'If element value is..';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::WITH_UI_ELEMENTS;
    }

    public function getDescription(): string
    {
        return 'Will be evaluated during interacting with UI and applied if condition is met';
    }

    /** @inheritDoc */
    public function shouldEvalWithValues(): array
    {
        return [];
    }

    public function shouldEvalAtStep(): AppStep
    {
        return AppStep::NONE;
    }
}
