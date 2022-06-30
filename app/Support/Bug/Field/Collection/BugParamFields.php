<?php

namespace AyaQA\Support\Bug\Field\Collection;

use AyaQA\Support\Bug\Field\Base\BaseFieldCollection;
use AyaQA\Support\Bug\Field\BugParamField;

class BugParamFields extends BaseFieldCollection
{
    public static function isCollectionOf(): string
    {
        return BugParamField::class;
    }
}
