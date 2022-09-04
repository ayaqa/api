<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Bug\Bug;
use AyaQA\Support\BugFramework\Condition\Condition;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Value\SectionId;
use JsonSerializable;

class ConfiguredBug implements JsonSerializable
{
    public function __construct(
        public readonly SectionId $target,
        public readonly ApplicableTo $applicable,
        public readonly Bug $bug,
        public readonly Condition $condition
    ){}

    public function jsonSerialize(): array
    {
        return [
            'target' => $this->target->value(),
            'applicable' => $this->applicable->get(),
            'bug' => $this->bug->getId(),
            'bugConfig' => $this->bug->getConfig()->asArray(),
            'condition' => $this->condition->getId(),
            'conditionConfig' => $this->condition->getConfig()->asArray(),
        ];
    }
}
