<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Value\Base\AbstractBugValueCollection;
use AyaQA\Support\BugFramework\Value\ParamValue;

class Params extends AbstractBugValueCollection
{
    public static function isCollectionOf(): string
    {
        return ParamValue::class;
    }
}
