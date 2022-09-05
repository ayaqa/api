<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\BaseValueCollection;
use AyaQA\Support\BugFramework\Value\HeaderParamValue;

class HeaderParams extends BaseValueCollection
{
    public static function isCollectionOf(): string
    {
        return HeaderParamValue::class;
    }
}
