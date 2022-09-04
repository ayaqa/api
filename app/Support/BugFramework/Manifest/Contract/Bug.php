<?php

namespace AyaQA\Support\BugFramework\Manifest\Contract;

use AyaQA\Support\BugFramework\Support\ApplicableTo;

interface Bug extends HasConfigType
{
    public function getId(): string;

    public function getText(): string;

    public function applicableTo(): ApplicableTo;

    public function getSupportedConditions(): array;
}
