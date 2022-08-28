<?php

namespace AyaQA\Support\Bug\Value\Collection;

use AyaQA\Support\Bug\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\Bug\Value\BugPostParam;

class BugPostParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return BugPostParam::class;
    }
}
