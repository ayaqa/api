<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Condition\Operator\OperatorGroup;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Support\Contract\HasId;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValueCollection;

class Condition implements HasId
{
    protected bool $isSatisfied = false;

    public function __construct(
        private readonly string $id,
        private readonly Config $conditionConfig,
        private readonly AppStep $evalAtStep,
        private readonly OperatorGroup $operatorGroup,
    ){}

    public function isSatisfied(): bool
    {
        return $this->id === ConditionType::ALWAYS->getId() ||  $this->isSatisfied;
    }

    public function evaluate(BugValue|BugValueCollection $value): void
    {
        // if is already satisfied - just skip
        if ($this->isSatisfied()) {
            return;
        }

        $result = false;
        if ($value instanceof BugValueCollection) {
            foreach ($value as $bugValue) {
                $result = $this->operatorGroup->allAreSatisfied($this->conditionConfig, $bugValue);

                if ($result) {
                    break;
                }
            }
        } else {
            $result = $this->operatorGroup->allAreSatisfied($this->conditionConfig, $value);
        }

        $this->isSatisfied = $result;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->conditionConfig;
    }

    public function evalAtStep(): AppStep
    {
        return $this->evalAtStep;
    }

    public function getType(): ConditionType
    {
        return ConditionType::from($this->getId());
    }
}
