<?php

namespace AyaQA\Support\Bug\Manifest\Condition;

use AyaQA\Support\Bug\Condition\ConditionType;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ConfigType;
use AyaQA\Support\Bug\Value\BugValueType;

class IfReqParamKeyExistsCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::IF_REQ_PARAM_KEY_EXISTS->get();
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
    public function evaluateAgainst(): array
    {
        return [
            BugValueType::POST_PARAM,
            BugValueType::GET_PARAM
        ];
    }
}
