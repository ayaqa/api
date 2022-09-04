<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\BugFramework\Value\GetParamValue;

class GetParams extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return GetParamValue::class;
    }
}
