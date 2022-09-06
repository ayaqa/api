<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Storage;

use AyaQA\Models\Core\Bug;
use AyaQA\Support\BugFramework\Bug\BugFactory;
use AyaQA\Support\BugFramework\ConfiguredBugs;

class BugDatabaseService implements BugStorageService
{
    public function __construct(
        private BugFactory $factory,
    ){}

    public function getBugs(): ConfiguredBugs
    {
        $collection = Bug::all()->toArray();

        return $this->factory->createConfiguredBugs($collection);
    }

    public function storeBugs(array $bugs): ConfiguredBugs
    {
        // clear table before storing new records
        Bug::truncate();

        foreach ($bugs as $bug) {
            Bug::create($bug)->save();
        }

        return $this->getBugs();
    }
}
