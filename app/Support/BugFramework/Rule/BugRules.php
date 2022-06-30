<?php

namespace AyaQA\Support\BugFramework\Rule;

use AyaQA\Support\BugFramework\BugTarget;

class BugRules
{
    protected array $rules = [];

    public function add(BugRule $rule): self
    {
        if (false == $this->hasRulesForTarget($rule->getTarget())) {
            $this->rules[$rule->getTarget()->asString()] = [];
        }

        $this->rules[$rule->getTarget()->asString()][] = $rule;

        return $this;
    }

    public function hasRules(): bool
    {
        return false === empty($this->rules);
    }

    public function hasRulesForTarget(BugTarget $target): bool
    {
        return isset($this->rules[$target->asString()]);
    }

    /**
     * @return BugRule[]
     */
    public function getRulesByTarget(BugTarget $target): array
    {
        if ($this->hasRulesForTarget($target)) {
            return $this->rules[$target->asString()];
        }

        return [];
    }

    /**
     * @return BugRule[]
     */
    public function all(): array
    {
        $rulesReturn = [];
        foreach ($this->rules as $rules) {
            $rulesReturn = array_merge($rulesReturn, $rules);
        }

        return $rulesReturn;
    }
}
