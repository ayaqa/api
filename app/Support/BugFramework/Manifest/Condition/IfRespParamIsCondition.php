<?php

namespace AyaQA\Support\BugFramework\Manifest\Condition;

use AyaQA\Support\BugFramework\AppFlowStep;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\Manifest\Contract\BugCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ConfigType;
use AyaQA\Support\BugFramework\Value\ValueType;

class IfRespParamIsCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::IF_RESP_PARAM_IS->getId();
    }

    public function getText(): string
    {
        return 'If response param is';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::RESP_PARAMETERS;
    }

    public function getDescription(): string
    {
        return 'Will be satisfied if response parameter key exists and is equal to configured value. (case insensitive)';
    }

    /** @inheritDoc */
    public function shouldEvalWithValues(): array
    {
        return [
            ValueType::RESPONSE_PARAM,
        ];
    }

    public function shouldEvalAtStep(): AppFlowStep
    {
        return AppFlowStep::POST_CONTROLLER;
    }
}
