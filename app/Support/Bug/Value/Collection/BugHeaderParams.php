<?php

namespace AyaQA\Support\Bug\Value\Collection;

use AyaQA\Support\Bug\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\Bug\Value\BugHeaderParam;

class BugHeaderParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return BugHeaderParam::class;
    }
}
