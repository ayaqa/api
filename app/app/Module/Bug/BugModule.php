<?php

namespace AyaQA\Module\Bug;

use AyaQA\Core\Contract\Module\ModuleInterface;
use AyaQA\Module\Bug\Provider\BugRouteServiceProvider;

class BugModule implements ModuleInterface
{
    protected const MODULE_NAME = 'Bug';

    public function getModule(): string
    {
        return self::MODULE_NAME;
    }

    public function getKey(): string
    {
        return strtolower(self::MODULE_NAME);
    }

    public static function getProviders(): array
    {
        return [
            BugRouteServiceProvider::class
        ];
    }
}
