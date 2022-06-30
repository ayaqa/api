<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Condition\Contract\BugConditionOperator;
use AyaQA\Support\Bug\Condition\Contract\BugNotOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Field\Contract\BugFieldCollection;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;
use AyaQA\Support\Bug\Support\Value\Uuid;

class Condition
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly BugTarget $target,
        private BugConditionOperator $operator
    ) {}

    public function getTarget(): BugTarget
    {
        return $this->target;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function evaluate(int|string|null $value = null): bool
    {
        return $this->operator->compare($value);
    }

    public function canEvaluate(BugFieldValue|BugFieldCollection $value): bool
    {
        $field = $this->target->getBugField();
        if ($field->shouldBeCollection()) {
            return get_class($value) === $field->getCollectionClass();
        }

        return get_class($value) === $field->getFieldClass();
    }

    public function isNotOperator(): bool
    {
        return $this->operator instanceof BugNotOperator;
    }

    public function notComparedResult(): bool
    {
        return $this->operator->notComparedResult();
    }
}
