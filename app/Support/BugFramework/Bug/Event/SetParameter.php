<?php

namespace AyaQA\Support\BugFramework\Bug\Event;

use AyaQA\Support\BugFramework\Bug\Enum\ParamType;

class SetParameter
{
    public function __construct(
        public readonly ParamType $paramType,
        public readonly string|int $paramKey,
        public readonly mixed $paramValue
    ){}
}
