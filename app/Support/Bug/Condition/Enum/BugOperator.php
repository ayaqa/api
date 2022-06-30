<?php

namespace AyaQA\Support\Bug\Condition\Enum;

enum BugOperator
{
    case IS;
    case IS_NOT;
    case IS_EMPTY;
    case IS_NOT_EMPTY;
    case CONTAINS;
    case DOES_NOT_CONTAINS;
}
