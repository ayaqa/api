<?php

namespace AyaQA\Support\Bug\Manifest;

use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\BugTarget;

class ManifestFactory
{
    public function createTarget(string $class): BugTarget
    {
        // @TODO exception
        return $this->create($class);
    }

    public function createBug(string $class): Bug
    {
        // @TODO exception
        return $this->create($class);
    }

    public function createCondition(string $class): BugCondition
    {
        // @TODO exception
        return $this->create($class);
    }

    private function create(string $class)
    {
        if (false === class_exists($class)) {
            // @TODO exception
        }

        return new $class;
    }
}
