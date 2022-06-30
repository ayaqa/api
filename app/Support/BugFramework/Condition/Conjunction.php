<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Support\Concern\StringableEnum;

enum Conjunction: string
{
    use StringableEnum;

    case AND = 'AND';
    case OR = 'OR';
}
