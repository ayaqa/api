<?php

namespace AyaQA\Support\Bug\Manifest\Condition;

use AyaQA\Support\Bug\Condition\ConditionType;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Enum\ConfigType;

class AlwaysCondition implements BugCondition, HasDescription
{
    public function getId(): string
    {
        return ConditionType::ALWAYS->get();
    }

    public function getText(): string
    {
        return 'Always';
    }

    public function getDescription(): string
    {
        return 'This condition is satisfied always... all bugs that are using it will be permanent.';
    }

    public function getConfigType(): ConfigType
    {
        return ConfigType::NONE;
    }

    public function evaluateAgainst(): array
    {
        return [];
    }
}
