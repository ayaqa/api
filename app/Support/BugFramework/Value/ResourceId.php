<?php

namespace AyaQA\Support\BugFramework\Value;

use AyaQA\Support\BugFramework\Value\Concern\ComparableValue;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

class ResourceId implements BugField
{
    use ComparableValue;

    public function __construct(
        private string $resourceId,
    ) {}

    public function value(): string
    {
        return $this->resourceId;
    }
}
