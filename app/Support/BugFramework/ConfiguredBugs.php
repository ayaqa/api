<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Support\Collection\Collection;

class ConfiguredBugs extends Collection
{
    public static function isCollectionOf(): string
    {
        return ConfiguredBug::class;
    }
}
