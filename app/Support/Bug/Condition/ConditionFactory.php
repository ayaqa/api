<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Manifest\Enum\ConfigType;
use Throwable;

class ConditionFactory
{
    public function create(string $condition, array $config, ConfigType $configType): Condition
    {
        return new Condition(
            $condition,
            $this->createConfig($config, $configType),
            $this->createOperatorGroup($condition)
        );
    }

    public function createConfig(array $config, ConfigType $configType): ConditionConfig
    {
        return new ConditionConfig($config, $configType);
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
