<?php

namespace AyaQA\Support\BugFramework\Condition\Operator;

use AyaQA\Support\BugFramework\Condition\Contract\ConditionOperator;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

class OperatorGroup
{
    /** @var ConditionOperator[] */
    private array $operators = [];

    /**
     * @param ConditionOperator ...$operators
     *
     * @return static
     */
    public static function from(ConditionOperator ...$operators): self
    {
        $self = new self();
        $self->operators = $operators;

        return $self;
    }

    /**
     * @return array []
     */
    public function getConditions(): array
    {
        return $this->operators;
    }

    public function allAreSatisfied(Config $config, BugValue $value): bool
    {
        $areSatisfied = true;
        foreach ($this->operators as $operator) {
            $areSatisfied = $operator->compare($config, $value);

            if (false === $areSatisfied) {
                break;
            }
        }

        return $areSatisfied;
    }
}
