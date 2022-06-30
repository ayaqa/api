<?php

namespace AyaQA\Support\Bug\Condition\Resolver;

use AyaQA\Support\Bug\Bugs;
use AyaQA\Support\Bug\Context\BugContext;
use AyaQA\Support\Bug\Context\Exception\ContextException;

class ConditionResolver
{
    /**
     * @var array<string, bool>
     */
    private array $evalMap = [];

    public function __construct(
        private Bugs $bugs,
        private BugContext $context
    ) {}

    public function evaluate(): self
    {
        foreach ($this->bugs->getBugs() as $bug) {
            $bugUuid = (string) $bug->getUuid();

            // if is already evaluated - skip this one
            if (array_key_exists($bugUuid, $this->evalMap)) {
                continue;
            }

            $targets = $bug->getCondition()->getTargets();
            foreach ($targets as $target) {
                try {
                    $value = $this->context->get($target);
                } catch (ContextException) {
                    continue;
                }

                $bug->getCondition()->evaluate($value);
            }

            $this->evalMap[$bugUuid] = $bug->getCondition()->isSatisfied();
        }

        return $this;
    }
}
