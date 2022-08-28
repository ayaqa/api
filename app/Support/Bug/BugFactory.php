<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;

class BugFactory
{
    public function createBug(array $payload): Bug
    {
        if (false === $payload['applicable'] instanceof ApplicableTo) {
            $payload['applicable'] = ApplicableTo::from($payload['applicable']);
        }

        return new Bug(
            $payload['target'],
            $payload['applicable'],
            $payload['bug'],
            $payload['bugConfig'],
            $payload['condition'],
            $payload['conditionConfig']
        );
    }

    public function createBugs(array $bugs = []): Bugs
    {
        $bugsValueObject = new Bugs();
        foreach ($bugs as $bug) {
            $bugsValueObject->add(
                $this->createBug($bug)
            );
        }

        return $bugsValueObject;
    }
}
