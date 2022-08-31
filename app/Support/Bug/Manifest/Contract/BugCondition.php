<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

use AyaQA\Support\Bug\Value\BugValueType;

interface BugCondition extends HasConfigType
{
    public function getId(): string;
    public function getText(): string;

    /**
     * @return BugValueType[]
     */
    public function evaluateAgainst(): array;
}
