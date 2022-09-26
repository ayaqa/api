<?php

namespace AyaQA\Support\BugFramework\Manifest\Target;

use AyaQA\Enum\SectionId;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyRequestParameter;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifestTarget;

class AnyManifestTarget implements BugManifestTarget
{
    public const ANY_TARGET = 'any';

    public function getId(): string
    {
        return SectionId::ANY->getId();
    }

    public function getText(): string
    {
        return 'Any';
    }

    public function getSupportedBugs(): array
    {
        return [
            ModifyRequestParameter::class
        ];
    }

    public function getUIElements(): array
    {
        return [];
    }

    public function getRequestParams(): array
    {
        return [];
    }

    public function getResponseParams(): array
    {
        return [];
    }
}
