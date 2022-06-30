<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Condition\Contract\BugCondition;
use AyaQA\Support\BugFramework\Condition\Operators\NotOperator;
use AyaQA\Support\BugFramework\Condition\Contract\BugOperator;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Rule\BugRule;
use AyaQA\Support\BugFramework\Rule\BugRules;
use AyaQA\Support\BugFramework\Value\Contract\BugField;

class BugManager
{
    private bool $booted = false;

    public function __construct(
        private BugContext $context,
        private BugRules   $rules,
    ){}

    /**
     * This method will check for configured bugs and execute action if conditions are met.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->findBugs();
    }

    private function findBugs()
    {
        $rules = $this->rules->all();
        foreach ($rules as $rule) {
            $hasBug = $this->hasBug($rule);

            if ($hasBug) {
                $rule->getAction()->execute();
            }
        }
    }

    private function evaluateCondition(BugField $value, BugCondition $condition): bool
    {
        return $condition->evaluate($value);
    }

    /**
     * Generic method to check for bugs
     *
     * @param BugRule $rule
     *
     * @return bool
     */
    private function hasBug(BugRule $rule): bool
    {
        if ($rule->getCondition() instanceof NotOperator) {
            return $this->hasBugInCollection($rule)
                    && $this->hasBugInValue($rule);
        }

        return $this->hasBugInCollection($rule)
                || $this->hasBugInValue($rule);
    }

    /**
     * Check for bugs against context value
     *
     * @param BugRule $rule
     *
     * @return bool
     */
    private function hasBugInValue(BugRule $rule): bool
    {
        $target = $rule->getTarget();
        if (false === $this->context->hasValue($target)) {
            return false;
        }

        return $rule->getCondition()->evaluate($this->context->getValue($target));
    }

    /**
     * Check for bugs against context collections
     *
     * @param BugRule $rule
     *
     * @return bool
     */
    private function hasBugInCollection(BugRule $rule): bool
    {
        $target = $rule->getTarget();
        $hasBugs = false;
        if ($this->context->hasCollection($target)) {
            $hasBugs = $rule->getCondition()->evaluateCollection($this->context->getCollection($target));
        }

        return $hasBugs;
    }
}
