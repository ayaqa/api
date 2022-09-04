<?php

namespace AyaQA\Support\BugFramework\Bug\Service;

use AyaQA\Support\BugFramework\Bug\Enum\ParamType;

class ParameterReplaceContainer
{
    /**
     * @var array<string|integer, mixed>[]
     */
    private array $params = [];

    public function add(ParamType $type, string|int $paramKey, mixed $value): self
    {
        if (false === isset($this->params[$type->name])) {
            $this->params[$type->name] = [];
        }

        $this->params[$type->name][$paramKey] = $value;

        return $this;
    }

    public function has(ParamType $type): bool
    {
        return isset($this->params[$type->name]);
    }

    public function getParams(ParamType $type): array
    {
        if ($this->has($type)) {
            return $this->params[$type->name];
        }

        return [];
    }
}
