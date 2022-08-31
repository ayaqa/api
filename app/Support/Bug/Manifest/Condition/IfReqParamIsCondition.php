<?php

namespace AyaQA\Support\Bug\Manifest\Condition;

use AyaQA\Support\Bug\Condition\ConditionType;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ConfigType;
use AyaQA\Support\Bug\Value\BugValueType;

class IfReqParamIsCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::IF_REQ_PARAM_IS->get();
    }

    public function getText(): string
    {
        return 'If request param is';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::REQ_PARAMETERS;
    }

    public function getDescription(): string
    {
        return 'Will be satisfied if POST or GET parameter key exists and is equal to configured value. (case insensitive)';
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
