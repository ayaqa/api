<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Manifest\Enum\ConfigType;
use AyaQA\Support\Bug\Value\Custom\ConfigValue;

class ConditionConfig
{
    public function __construct(
        private readonly array $config,
        private readonly ConfigType $configType,
    ) {}

    /**
     * @return array
     */
    public function asArray(): array
    {
        return $this->config;
    }

    /**
     * @return ConfigValue
     */
    public function asValue(): ConfigValue
    {
        return new ConfigValue($this->getValue(), $this->getKey());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->config['value'] ?: '';
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->config['key'] ?: '';
    }

    /**
     * @return ConfigType
     */
    public function getConfigType(): ConfigType
    {
        return $this->configType;
    }
}
