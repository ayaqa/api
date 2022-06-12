<?php

namespace AyaQA\Support\BugFramework\Rule;

use AyaQA\Support\BugFramework\BugTarget;

class BugRules
{
    protected array $rules = [];

    public function add(BugRule $rule): self
    {
        if (false == $this->hasTargetRules($rule->getTarget())) {
            $this->rules[$rule->getTarget()->asString()] = [];
        }

        $this->rules[$rule->getTarget()->asString()][] = $rule;

        return $this;
    }

    public function hasRules(): bool
    {
        return false === empty($this->rules);
    }

    public function hasTargetRules(BugTarget $target): bool
    {
        return isset($this->rules[$target->asString()]);
    }

    /**
     * @return BugRule[]
     */
    public function getTargetRules(BugTarget $target): array
    {
        if ($this->hasTargetRules($target)) {
            return $this->rules[$target->asString()];
        }

        return [];
    }

    /**
     * @return BugRule[]
     */
    public function getAll(): array
    {
        return \Illuminate\Support\Arr::flatten($this->rules);
    }
}
