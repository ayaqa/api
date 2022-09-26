<?php

namespace AyaQA\Support\BugFramework\Manifest\Bug\API;

use AyaQA\Support\BugFramework\Bug\BugType;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamIsManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamKeyExistsManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifest;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\ConfigType;

class ModifyRequestParameter implements BugManifest, HasDescription
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
            AlwaysManifestCondition::class,
            IfReqParamIsManifestCondition::class,
            IfReqParamKeyExistsManifestCondition::class
        ];
    }
}
