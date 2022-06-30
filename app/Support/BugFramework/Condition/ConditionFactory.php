<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\Operators\EqualOperator;
use AyaQA\Support\BugFramework\Condition\Operators\NotOperator;
use AyaQA\Support\BugFramework\Condition\Contract\BugOperator;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

class ConditionFactory
{
    public function create(Conjunction $conjunction, BugOperator ...$operators): Condition
    {
        return new Condition($conjunction, ...$operators);
    }

    public function createOperator(string $operator, BugTarget $target, BugField $value): BugOperator
    {
        $type = Operator::from($operator);

        return $this->createOperatorByType($type, $target, $value);
    }

    public function createOperatorByType(Operator $type, BugTarget $target, BugField $value): BugOperator
    {
        return match ($type) {
            Operator::EQUAL => new EqualOperator($target, $value),
            Operator::NOT_EQUAL => new NotOperator($this->createOperatorByType(Operator::EQUAL, $target, $value)),
            default => throw new \RuntimeException(
                sprintf('There is no mapped class for %s', $type->value)
            )
        };
    }
}
