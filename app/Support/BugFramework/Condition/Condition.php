<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Condition\Contract\BugCondition;
use AyaQA\Support\BugFramework\Condition\Contract\BugOperator;
use AyaQA\Support\BugFramework\Condition\Operators\NotOperator;
use AyaQA\Support\BugFramework\Value\Contract\BugField;
use AyaQA\Support\BugFramework\Value\Contract\BugFieldCollection;

class Condition implements BugCondition
{
    private Conjunction $conjunction;

    /** @var BugOperator[] */
    private array $operators = [];

    /** @var BugOperator[] */
    private array $notOperators = [];

    public function __construct(
        Conjunction $conjunction,
        BugOperator ...$operators
    ) {
        $this->conjunction = $conjunction;

        foreach ($operators as $operator) {
            if ($operator instanceof NotOperator) {
                $this->notOperators[] = $operator;

                continue;
            }

            $this->operators[] = $operator;
        }
    }

    public function getTargets(): array
    {
        $targets = [];
        foreach ($this->getOperators() as $operator) {
            $targets[] = $operator->getTarget()->asString();
        }

        return array_unique($targets);
    }

    public function evaluate(BugField $value): bool
    {
        // prevent issue if collection is passed
        if ($value instanceof BugFieldCollection) {
            return $this->evaluateCollection($value);
        }

        $hasBug = false;
        foreach ($this->getOperators() as $operator) {
            $hasBug = $operator->evaluate($value);
            if ($hasBug && $this->conjunction === Conjunction::OR) {
                break;
            }

            if (false === $hasBug && $this->conjunction === Conjunction::AND) {
                break;
            }
        }

        return $hasBug;
    }

    public function evaluateCollection(BugFieldCollection $collection): bool
    {
        $hasBug = false;
        foreach ($collection->value() as $value) {
            $hasBug = $this->evaluate($value);

            if ($hasBug && $this->conjunction === Conjunction::OR) {
                break;
            }

            if (false === $hasBug && $this->conjunction === Conjunction::AND) {
                break;
            }
        }

        return $hasBug;
    }

    /**
     * @return BugOperator[]
     */
    private function getOperators(): array
    {
        return array_merge($this->operators, $this->notOperators);
    }
}
