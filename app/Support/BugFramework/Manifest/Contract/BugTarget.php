<?php

namespace AyaQA\Support\BugFramework\Manifest\Contract;

interface BugTarget
{
    public function getId(): string;
    public function getText(): string;

    public function getUIElements(): array;
    public function getRequestParams(): array;
    public function getResponseParams(): array;

    public function getSupportedBugs(): array;
}
