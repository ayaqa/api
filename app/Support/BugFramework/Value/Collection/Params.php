<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\BaseValueCollection;
use AyaQA\Support\BugFramework\Value\ParamValue;

class Params extends BaseValueCollection
{
    public static function isCollectionOf(): string
    {
        return ParamValue::class;
    }
}
