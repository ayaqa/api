<?php

namespace AyaQA\Core\Contract\Module;

interface ModuleInterface
{
    public const CONTAINER_MODULES_TAG = 'modules';

    public function getModule(): string;
    public function getKey(): string;

    public static function getProviders(): array;
}
