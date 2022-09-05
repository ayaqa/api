<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\BaseValueCollection;
use AyaQA\Support\BugFramework\Value\PostParamValue;

class PostParams extends BaseValueCollection
{
    public static function isCollectionOf(): string
    {
        return PostParamValue::class;
    }
}
