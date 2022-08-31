<?php

namespace AyaQA\Support\Bug;

use AyaQA\Models\Core\Bug;
use AyaQA\Support\Bug\Condition\Resolver\ConditionResolver;
use AyaQA\Support\Bug\Support\Exception\BugException;

/**
 * TODO
 *  - use this by actions
 *  - replace with better method names
 *
 */
class BugManager
{
    private bool $initialized = false;

    private Bugs $satisfiedBugs;

    public function __construct(
        private BugFactory $factory,
        private ConditionResolver $conditionResolver
    ){}

    /**
     * Init and eval all conditions if are satisfied.
     *
     * @param bool $force
     *
     * @return void
     */
    public function init(bool $force = false): void
    {
        if ($this->initialized && !$force) {
            return;
        }

        $satisfied = $this->factory->createBugs();
        $bugs = $this->getBugs();

        foreach ($bugs->asArray() as $bug) {
            $matching = $this->conditionResolver->matching($bug);

            if ($matching) {
                $satisfied->add($bug);
            }
        }

        $this->satisfiedBugs = $satisfied;
        $this->initialized = true;
    }

    /**
     * Will return bug conditions will
     */
    public function getSatisfiedBugs(): Bugs
    {
        if (false === $this->initialized) {
            throw new BugException('BugManager is not initialized.');
        }

        return $this->satisfiedBugs;
    }

    public function storeBugs(array $bugs)
    {
        // @TODO validation of keys and allowed values

        // clear table before storing new records
        Bug::truncate();

        foreach ($bugs as $bug) {
            Bug::create($bug)->save();
        }
    }

    public function getBugs(): Bugs
    {
        $collection = Bug::all()->toArray();

        return $this->factory->createBugs($collection);
    }
}
