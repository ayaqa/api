<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\AppFlowStep;
use AyaQA\Support\BugFramework\Condition\Operator\OperatorGroup;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Support\ConfigType;
use Throwable;

class ConditionFactory
{
    public function create(string $condition, array $config, ConfigType $configType, AppFlowStep $evalAtStep): Condition
    {
        return new Condition(
            $condition,
            $this->createConfig($config, $configType),
            $evalAtStep,
            $this->createOperatorGroup($condition),
        );
    }

    public function createConfig(array $config, ConfigType $configType): Config
    {
        return new Config($config, $configType);
    }

    public function createOperatorGroup(string $condition): OperatorGroup
    {
        try {
            $operatorClasses = ConditionType::from($condition)->getOperators();
            $operators = [];
            foreach ($operatorClasses as $class) {
                $operators[] = new $class;
            }

        } catch (Throwable) {
            $operators = [];
        }

        return OperatorGroup::from(...$operators);
    }
}
