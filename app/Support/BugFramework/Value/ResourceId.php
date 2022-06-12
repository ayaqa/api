<?php

namespace AyaQA\Support\BugFramework\Value;

use AyaQA\Support\BugFramework\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Concern\ComparableValue;

class ResourceId implements BugValue
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
