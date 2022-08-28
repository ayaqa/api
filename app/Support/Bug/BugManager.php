<?php

namespace AyaQA\Support\Bug;

use AyaQA\Models\Core\Bug;

/**
 * TODO
 *  - use this by actions
 *  - replace with better method names
 *
 */
class BugManager
{
    public function __construct(
        private BugFactory $factory
    ){}

    public function replaceBugs(array $bugs)
    {
        // @TODO validation of keys and allowed values

        // clear table before storing new records
        Bug::truncate();

        foreach ($bugs as $bug) {
            Bug::create($bug)->save();
        }
    }

    public function fetchBugs(): Bugs
    {
        $collection = Bug::all()->toArray();

        return $this->factory->createBugs($collection);
    }
}
