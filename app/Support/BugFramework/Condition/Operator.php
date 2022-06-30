<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Support\Concern\StringableEnum;

enum Operator: string
{
    use StringableEnum;

    case EQUAL = 'EQUAL';
    case NOT_EQUAL = 'NOT_EQUAL';
}
