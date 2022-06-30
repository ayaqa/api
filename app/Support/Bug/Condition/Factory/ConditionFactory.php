<?php

namespace AyaQA\Support\Bug\Condition\Factory;

use AyaQA\Support\Bug\Condition\Condition;
use AyaQA\Support\Bug\Condition\ConditionGroup;
use AyaQA\Support\Bug\Condition\Contract\BugConditionOperator;
use AyaQA\Support\Bug\Condition\Contract\BugConditionOperatorValue;
use AyaQA\Support\Bug\Condition\Enum\BugOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Condition\Enum\Conjunction;
use AyaQA\Support\Bug\Condition\Operator\BugContainsOperator;
use AyaQA\Support\Bug\Condition\Operator\BugIsEmptyOperator;
use AyaQA\Support\Bug\Condition\Operator\BugIsNotEmptyOperator;
use AyaQA\Support\Bug\Condition\Operator\BugIsNotOperator;
use AyaQA\Support\Bug\Condition\Operator\BugIsOperator;
use AyaQA\Support\Bug\Condition\Value\BugLiteralOperatorValue;
use AyaQA\Support\Bug\Support\Value\Uuid;

class ConditionFactory
{
    public function createGroup(Conjunction $conjunction, Condition ...$condition): ConditionGroup
    {
        return new ConditionGroup($conjunction, ...$condition);
    }

    public function createCondition(BugTarget $target, BugOperator $operator, string|int|null $comparable = null): Condition
    {
        $operator = $this->createOperator($operator, $comparable);

        return new Condition(Uuid::create(), $target, $operator);
    }

    public function createOperator(BugOperator $operator, string|int|null $comparable = null): BugConditionOperator
    {
        $value = $this->createOperatorValue($comparable);

        return match($operator) {
            BugOperator::IS_EMPTY       => new BugIsEmptyOperator(),
            BugOperator::IS_NOT_EMPTY   => new BugIsNotEmptyOperator(),
            BugOperator::IS             => new BugIsOperator($value),
            BugOperator::IS_NOT         => new BugIsNotOperator($value),
            BugOperator::CONTAINS       => new BugContainsOperator($value),
        };
    }

    public function createOperatorValue(string|int|null $comparable = null): BugConditionOperatorValue
    {
        return new BugLiteralOperatorValue($comparable);
    }
}
