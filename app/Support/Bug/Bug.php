<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Condition\ConditionGroup;
use AyaQA\Support\Bug\Support\Value\Uuid;

class Bug
{
    public function __construct(
        private readonly Uuid $uuid,
        private ConditionGroup $conditionGroup,
    ){}

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return ConditionGroup
     */
    public function getCondition(): ConditionGroup
    {
        return $this->conditionGroup;
    }
}
