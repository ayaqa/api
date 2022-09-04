<?php

namespace AyaQA\Support\BugFramework\Value\Contract;

interface BugValueCollection
{
    /**
     * @return class-string
     */
    public static function isCollectionOf(): string;

    public function values(): array;

    public function contains(BugValue $value): bool;
}
