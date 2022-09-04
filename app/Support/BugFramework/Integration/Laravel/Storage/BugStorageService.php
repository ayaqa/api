<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Storage;

use AyaQA\Support\BugFramework\ConfiguredBugs;

interface BugStorageService
{
    public function getBugs(): ConfiguredBugs;
    public function storeBugs(array $bugs): ConfiguredBugs;
}
