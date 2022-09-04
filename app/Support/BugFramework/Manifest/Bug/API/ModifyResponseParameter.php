<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\API;

use AyaQA\Support\BugFramework\Bug\BugMapper;
use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamIsCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamKeyExistsCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfRespParamIsCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\Bug;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class ModifyResponseParameter implements Bug, HasDescription
{
    public function getId(): string
    {
        return BugType::MODIFY_RESP_PARAM->getId();
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
