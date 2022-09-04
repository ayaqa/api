<?php

namespace AyaQA\Support\BugFramework\Manifest\Condition;

use AyaQA\Support\BugFramework\AppFlowStep;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\Manifest\Contract\BugCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ConfigType;
use AyaQA\Support\BugFramework\Value\ValueType;

class IfReqParamKeyExistsCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::IF_REQ_PARAM_KEY_EXISTS->getId();
    }

    public function getText(): string
    {
        return 'If request param key exists';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::REQ_PARAMETER_KEY;
    }

    public function getDescription(): string
    {
        return 'Will be satisfied if POST or GET parameter key exists';
    }

    /** @inheritDoc */
    public function shouldEvalWithValues(): array
    {
        return [
            ValueType::POST_PARAM,
            ValueType::GET_PARAM
        ];
    }

    public function shouldEvalAtStep(): AppFlowStep
    {
        return AppFlowStep::PRE_CONTROLLER;
    }
}
