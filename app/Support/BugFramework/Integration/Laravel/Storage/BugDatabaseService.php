<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Storage;

use AyaQA\Models\Core\Bug;
use AyaQA\Support\BugFramework\Bug\BugFactory;
use AyaQA\Support\BugFramework\ConfiguredBug;
use AyaQA\Support\BugFramework\ConfiguredBugs;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifest;
use Closure;

class BugDatabaseService implements BugStorageService
{
    public function __construct(
        private BugFactory $factory,
    ){}

    public function storeBugs(array $bugs): ConfiguredBugs
    {
        // clear table before storing new records
        Bug::truncate();

        foreach ($bugs as $bug) {
            Bug::create($bug)->save();
        }

        return $this->getBugs();
    }

    public function getBugs(Closure $callback = null): ConfiguredBugs
    {
        $collection = Bug::all()->toArray();

        if (null === $callback) {
            return $this->factory->createConfiguredBugs($collection);
        }

        $bugs = $this->factory->createConfiguredBugs();
        foreach ($collection as $bugRow) {
            $bug = $this->factory->createConfiguredBug($bugRow);
            $bugManifest = $this->factory->createBugManifest($bug->bug->getId());

            if ($callback($bugManifest)) {
                $bugs->append($bug);
            }
        }

        return $bugs;
    }

    public function getAPIBugs(): ConfiguredBugs
    {
        return $this->getBugs(fn (BugManifest $bugManifest) => $bugManifest->applicableTo()->api());
    }

    public function getUIBugs(): ConfiguredBugs
    {
        return $this->getBugs(fn (BugManifest $bugManifest) => $bugManifest->applicableTo()->app());
    }
}
