<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

interface BugTarget
{
    public function getId(): string;
    public function getText(): string;

    public function getUIElements(): array;
    public function getRequestParams(): array;

    public function getSupportedBugs(): array;
}
