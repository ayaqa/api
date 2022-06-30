<?php

namespace AyaQA\Support\Bug\Field\Contract;

interface BugFieldCollection
{
    /**
     * @return class-string
     */
    public static function isCollectionOf(): string;

    /**
     * @return BugFieldValue[]
     */
    public function toArray(): array;

    public function contains(BugFieldValue $value): bool;
}
