<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\API;

use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamIsCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamKeyExistsCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\Bug;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class ModifyRequestParameter implements Bug, HasDescription
{
    public function getId(): string
    {
        return BugType::MODIFY_REQ_PARAM->getId();
    }

    public function getText(): string
    {
        return 'Modify request parameter';
    }

    public function applicableTo(): ApplicableTo
    {
        return ApplicableTo::API;
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::REQ_PARAMETERS;
    }

    public function getDescription(): string
    {
        return 'Parameter will be modified to configured value in APP request object.';
    }

    public function getSupportedConditions(): array
    {
        return [
            AlwaysCondition::class,
            IfReqParamIsCondition::class,
            IfReqParamKeyExistsCondition::class
        ];
    }
}
