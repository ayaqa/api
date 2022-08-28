<?php

namespace AyaQA\Support\Bug\Value\Contract;

interface BugValueCollection
{
    /**
     * @return class-string
     */
    public static function isCollectionOf(): string;

    public function values(): array;

    public function contains(BugValue $value): bool;
}
