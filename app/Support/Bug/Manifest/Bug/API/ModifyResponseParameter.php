<?php

namespace AyaQA\Support\Bug\Manifest\Bug\API;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamIsCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamKeyExistsCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfRespParamIsCondition;
use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\Enum\ConfigType;

class ModifyResponseParameter implements Bug, HasDescription
{
    public function getId(): string
    {
        return BugMapper::getBugId(self::class);
    }

    public function getText(): string
    {
        return 'Modify response parameter';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::API;
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::RESP_PARAMETERS;
    }

    public function getDescription(): string
    {
        return 'Parameter will be modified to configured value before response is returned.';
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysCondition::class,
            IfReqParamIsCondition::class,
            IfReqParamKeyExistsCondition::class,
            IfRespParamIsCondition::class
        ];
    }
}
