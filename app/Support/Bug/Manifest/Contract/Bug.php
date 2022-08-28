<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;

interface Bug extends Configurable
{
    public function getId(): string;

    public function getText(): string;

    public function applicableTo(): ApplicableTo;

    public function getSupportedConditions(): array;
}
