<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Condition\Condition;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Value\BugSectionId;
use JsonSerializable;

class Bug implements JsonSerializable
{
    public function __construct(
        public readonly BugSectionId $target,
        public readonly ApplicableTo $applicable,
        public readonly string $bug,
        public readonly array $bugConfig,
        public readonly Condition $condition
    ){}

    public function jsonSerialize(): array
    {
        return [
            'target' => $this->target->value(),
            'applicable' => $this->applicable->get(),
            'bug' => $this->bug,
            'bugConfig' => $this->bugConfig,
            'condition' => $this->condition->getId(),
            'conditionConfig' => $this->condition->getConfig()->asArray(),
        ];
    }
}
