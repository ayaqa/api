<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\BaseValueCollection;
use AyaQA\Support\BugFramework\Value\GetParamValue;

class GetParams extends BaseValueCollection
{
    public static function isCollectionOf(): string
    {
        return GetParamValue::class;
    }
}
