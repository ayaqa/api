<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Condition\Conditions\NotCondition;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Contract\BugCondition;
use AyaQA\Support\BugFramework\Contract\BugValue;
use AyaQA\Support\BugFramework\Rule\BugRule;
use AyaQA\Support\BugFramework\Rule\BugRules;

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
    public function bugsInStage(): void
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;
        $this->checkConfiguredBugsAgainstContext();
    }

    private function checkConfiguredBugsAgainstContext()
    {
        $rules = $this->rules->getAll();
        foreach ($rules as $rule) {
            $hasBug = $this->hasBug($rule);

            if ($hasBug) {
                $rule->getAction()->execute();
            }
        }
    }

    private function evaluateCondition(BugValue $value, BugCondition $condition): bool
    {
        return $condition->compare($value);
    }

    private function hasBug(BugRule $rule): bool
    {
        if ($rule->getCondition() instanceof NotCondition) {
            return $this->hasBugInCollection($rule)
                    && $this->hasBugInValue($rule);
        }

        return $this->hasBugInCollection($rule)
                || $this->hasBugInValue($rule);
    }

    private function hasBugInValue(BugRule $rule): bool
    {
        $target = $rule->getTarget();
        $hasBug = $rule->getCondition() instanceof NotCondition;;
        if (false === $this->context->hasValue($target)) {
            return $hasBug;
        }

        return $this->evaluateCondition(
            $this->context->getValue($target),
            $rule->getCondition(),
        );
    }

    private function hasBugInCollection(BugRule $rule): bool
    {
        $target = $rule->getTarget();
        $isNotCondition = $rule->getCondition() instanceof NotCondition;
        $hasBugs = $isNotCondition;
        if ($this->context->hasCollection($target)) {
            foreach ($this->context->getCollection($target)->value() as $contextValue) {
                $hasBugs = $this->evaluateCondition(
                    $contextValue,
                    $rule->getCondition(),
                );

                if ($hasBugs && false === $isNotCondition) {
                    break;
                }

                // in case of NOT wrapper - it shouldn't have matching
                if (false === $hasBugs && $isNotCondition) {
                    break;
                }
            }
        }

        return $hasBugs;
    }
}
