<?php

namespace AyaQA\Support\BugFramework\Manifest\Contract;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Value\ValueType;

interface BugManifestCondition extends HasConfigType
{
    public function getId(): string;
    public function getText(): string;

    /**
     * @return ValueType[]
     */
    public function shouldEvalWithValues(): array;
    public function shouldEvalAtStep(): AppStep;
}
