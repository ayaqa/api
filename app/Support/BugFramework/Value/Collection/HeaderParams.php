<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\BugFramework\Value\HeaderParamValue;

class HeaderParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return HeaderParamValue::class;
    }
}
