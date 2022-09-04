<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\BugFramework\Value\PostParamValue;

class PostParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return PostParamValue::class;
    }
}
