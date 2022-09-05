<?php

namespace AyaQA\Support\BugFramework\Manifest\Condition;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\Manifest\Contract\BugCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ConfigType;

class AlwaysCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::ALWAYS->getId();
    }

    public function getText(): string
    {
        return 'Always';
    }

    public function getDescription(): string
    {
        return 'This condition is satisfied always... all bugs that are using it will be permanent.';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::NONE;
    }

    public function shouldEvalWithValues(): array
    {
        return [];
    }

    public function shouldEvalAtStep(): AppStep
    {
        return AppStep::PRE_CONTROLLER;
    }
}
