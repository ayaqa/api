<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Manifest\Enum\ConfigType;
use AyaQA\Support\Bug\Value\Contract\BugValue;
use AyaQA\Support\Bug\Value\Contract\BugValueCollection;

class Condition
{
    public function __construct(
        private readonly string $id,
        private readonly ConditionConfig $conditionConfig,
        private readonly OperatorGroup $operatorGroup
    ){}

    public function isSatisfied(BugValue|BugValueCollection $value): bool
    {
        $result = false;
        if ($value instanceof BugValueCollection) {
            foreach ($value->values() as $bugValue) {
                $result = $this->evaluate($bugValue);

                if ($result) {
                    break;
                }

            }
        } else {
            $result = $this->evaluate($value);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return ConditionConfig
     */
    public function getConfig(): ConditionConfig
    {
        return $this->conditionConfig;
    }

    protected function evaluate(BugValue $value): bool
    {
        return $this->operatorGroup->allAreSatisfied($this->conditionConfig, $value);
    }
}
