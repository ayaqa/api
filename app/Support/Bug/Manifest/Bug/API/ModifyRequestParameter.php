<?php

namespace AyaQA\Support\Bug\Manifest\Bug\API;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamIsCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamKeyExistsCondition;
use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\Enum\ConfigType;

class ModifyRequestParameter implements Bug, HasDescription
{
    public function getId(): string
    {
        return BugMapper::getBugId(self::class);
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
