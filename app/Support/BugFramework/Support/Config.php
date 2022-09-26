<?php

namespace AyaQA\Support\BugFramework\Support;

use AyaQA\Support\BugFramework\Support\Concern\Arrayable;
use AyaQA\Support\BugFramework\Support\Contract\HasToArray;
use AyaQA\Support\BugFramework\Value\Custom\ConfigValue;

class Config implements HasToArray
{
    use Arrayable;
    
    public function __construct(
        private readonly array $config,
        private readonly ConfigType $configType,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->config;
    }

    /**
     * @return ConfigValue
     */
    public function asValue(): ConfigValue
    {
        return new ConfigValue($this->getKey(), $this->getValue());
    }

    /**
     * @return string|bool|int
     */
    public function getValue(): string|bool|int
    {
        $val = $this->config['value'] ?: '';

        // if is true/false as string
        if (in_array($val, ['true', 'false'])) {
            return $val === 'true';
        }

        if (is_int($val)) {
            return $val;
        }

        return (string) $val;
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
