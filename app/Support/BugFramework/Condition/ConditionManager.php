<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Bug\BugFactory;
use AyaQA\Support\BugFramework\ConfiguredBugs;
use AyaQA\Support\BugFramework\Condition\Resolver\ConditionResolver;

class ConditionManager
{
    public function __construct(
        private BugFactory $bugFactory,
        private ConditionResolver $conditionResolver,
        private ConfiguredBugs $bugs
    ){}

    /**
     * Will go thru all bugs and call eval to each of them
     *
     * @return void
     */
    public function evaluate()
    {
        foreach ($this->bugs->toArray() as $bug) {
            $this->conditionResolver->evalCondition($bug);
        }
    }

    /**
     * Will return new instance of Bugs with satisfied bugs only
     *
     * @return ConfiguredBugs
     */
    public function getSatisfiedBugs(): ConfiguredBugs
    {
        $bugs = $this->bugFactory->createConfiguredBugs();
        foreach ($this->bugs->toArray() as $bug) {
            if ($bug->condition->isSatisfied()) {
                $bugs->add($bug);
            }
        }

        return $bugs;
    }

    /**
     * Will get rid of all bugs that are not configured against current target.
     *
     * @return void
     */
    public function filterOnlyTargetBugs(): void
    {
        $bugs = $this->bugFactory->createConfiguredBugs();
        foreach ($this->bugs->toArray() as $bug) {
            if ($this->conditionResolver->hasSameTarget($bug)) {
                $bugs->add($bug);
            }
        }

        $this->bugs = $bugs;
    }
}
