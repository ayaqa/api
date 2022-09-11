<?php

namespace AyaQA\Support\BugFramework\Manifest;

use AyaQA\Support\BugFramework\Manifest\Contract\BugManifest;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifestTarget;

class ManifestFactory
{
    public function createTarget(string $class): BugManifestTarget
    {
        // @TODO exception
        return $this->create($class);
    }

    public function createBug(string $class): BugManifest
    {
        // @TODO exception
        return $this->create($class);
    }

    public function createCondition(string $class): BugManifestCondition
    {
        // @TODO exception
        return $this->create($class);
    }

    private function create(string $class): mixed
    {
        if (false === class_exists($class)) {
            // @TODO exception
        }

        return new $class;
    }
}
