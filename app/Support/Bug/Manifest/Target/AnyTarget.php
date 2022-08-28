<?php

namespace AyaQA\Support\Bug\Manifest\Target;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Bug\ModifyRequestParameter;
use AyaQA\Support\Bug\Manifest\Contract\BugTarget;

class AnyTarget implements BugTarget
{
    public function getId(): string
    {
        return BugMapper::getTargetId(self::class);
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
}
