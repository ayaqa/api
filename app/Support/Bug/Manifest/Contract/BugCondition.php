<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

interface BugCondition extends Configurable
{
    public function getId(): string;
    public function getText(): string;
}
