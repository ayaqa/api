<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Condition\Enum\Conjunction;
use AyaQA\Support\Bug\Field\Contract\BugFieldCollection;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

class ConditionGroup
{
    private readonly Conjunction $conjunction;
    private array $conditions = [];

    private array $conditionUuids = [];
    private array $resultMap = [];
    private array $notComparedResultMap = [];

    public function __construct(
        Conjunction $conjunction,
        Condition ...$conditions
    ) {
        $this->conjunction = $conjunction;
        $this->conditions = $conditions;
    }

    /**
     * @return Condition[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getTargets(): array
    {
        $targets = [];
        foreach ($this->getConditions() as $condition) {
            $target = $condition->getTarget();
            if (false === in_array($target, $targets)) {
                continue;
            }

            $targets[] = $target;
        }
    }

    public function isSatisfied(): bool
    {
        $resultMap = array_merge($this->notComparedResultMap, $this->resultMap);

        if ($this->conjunction === Conjunction::OR && in_array(true, $resultMap)) {
            return true;
        }

        if (
            // result map should match condition meta - which means all are evaluated
            count($resultMap) === count($this->conditionUuids)
            // it should be AND conjunction
            && Conjunction::AND === $this->conjunction
            // and it shouldn't have false ones
            && false === in_array(false, $resultMap)
        ) {
            return true;
        }

        return false;
    }

    public function evaluate(BugFieldValue|BugFieldCollection $value): self
    {
        foreach ($this->conditions as $condition) {
            $uuid = (string) $condition->getUuid();
            $this->addConditionMeta($condition);

            $isEvaluated = isset($this->resultMap[$uuid]);
            $oneMatchingOR = $this->conjunction === Conjunction::OR && in_array(true, $this->resultMap);
            $oneFailsAND = $this->conjunction === Conjunction::AND && in_array(false, $this->resultMap);

            if ($isEvaluated || $oneMatchingOR || $oneFailsAND) {
                continue;
            }

            $canEval = $condition->canEvaluate($value);
            if ($canEval) {
                $this->resultMap[$uuid] = $this->handleEvaluate($value, $condition);
            }
        }

        return $this;
    }

    protected function handleEvaluate(BugFieldValue|BugFieldCollection $value, Condition $condition): bool
    {
        if ($value instanceof BugFieldValue) {
            return $condition->evaluate($value->value());
        }

        $isMatching = false;
        foreach ($value->toArray() as $field) {
            $value = $condition->getTarget()->getFieldValue($field);
            $isMatching = $condition->evaluate($value);

            $trueAndIsNotOperator = $isMatching && false === $condition->isNotOperator();
            $falseAndIsItNotOperator = false === $isMatching && $condition->isNotOperator();
            if ($trueAndIsNotOperator || $falseAndIsItNotOperator) {
                break;
            }
        }

        return $isMatching;
    }

    protected function addConditionMeta(Condition $condition): void
    {
        $uuid = (string) $condition->getUuid();
        if (false === in_array($uuid, $this->conditionUuids)) {
            $this->conditionUuids[] = $uuid;
        }

        $this->notComparedResultMap[$uuid] = $condition->notComparedResult();
    }
}
