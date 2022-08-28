<?php

namespace AyaQA\Support\Bug\Value\Collection;

use AyaQA\Support\Bug\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\Bug\Value\BugParam;

class BugParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return BugParam::class;
    }
}
