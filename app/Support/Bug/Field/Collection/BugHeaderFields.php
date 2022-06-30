<?php

namespace AyaQA\Support\Bug\Field\Collection;

use AyaQA\Support\Bug\Field\Base\BaseFieldCollection;
use AyaQA\Support\Bug\Field\BugHeaderField;

class BugHeaderFields extends BaseFieldCollection
{
    public static function isCollectionOf(): string
    {
        return BugHeaderField::class;
    }
}
