<?php

namespace AyaQA\Support\Bug\Field;

use AyaQA\Support\Bug\Field\Concern\ComparableFieldValue;
use AyaQA\Support\Bug\Field\Concern\SimpleFieldValue;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

class BugPageIdField implements BugFieldValue
{
    use SimpleFieldValue, ComparableFieldValue;
}
