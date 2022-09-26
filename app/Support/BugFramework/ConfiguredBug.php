<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Bug\Bug;
use AyaQA\Support\BugFramework\Condition\Condition;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\Concern\Arrayable;
use AyaQA\Support\BugFramework\Support\Contract\HasToArray;
use AyaQA\Support\BugFramework\Value\SectionId;

class ConfiguredBug implements HasToArray
{
    use Arrayable;

    public function __construct(
        public readonly SectionId $target,
        public readonly ApplicableTo $applicable,
        public readonly Bug $bug,
        public readonly Condition $condition
    ){}

    public function toArray(): array
    {
        return [
            'target' => $this->target->value(),
            'applicable' => $this->applicable->getId(),
            'bug' => $this->bug->getId(),
            'bugConfig' => $this->bug->getConfig()->toArray(),
            'condition' => $this->condition->getId(),
            'conditionConfig' => $this->condition->getConfig()->toArray(),
        ];
    }
}
