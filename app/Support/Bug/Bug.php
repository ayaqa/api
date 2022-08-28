<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use JsonSerializable;

class Bug implements JsonSerializable
{
    public function __construct(
        protected readonly string $target,
        protected readonly ApplicableTo $applicable,
        protected readonly string $bug,
        protected readonly array $bugConfig,
        protected readonly string $condition,
        protected readonly array $conditionConfig
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'target' => $this->target,
            'applicable' => $this->applicable->get(),
            'bug' => $this->bug,
            'bugConfig' => $this->bugConfig,
            'condition' => $this->condition,
            'conditionConfig' => $this->conditionConfig,
        ];
    }
}
