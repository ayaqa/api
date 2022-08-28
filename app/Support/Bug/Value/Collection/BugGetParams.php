<?php

namespace AyaQA\Support\Bug\Value\Collection;

use AyaQA\Support\Bug\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\Bug\Value\BugGetParam;

class BugGetParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return BugGetParam::class;
    }
}
