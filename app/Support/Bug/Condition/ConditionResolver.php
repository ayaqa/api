<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Bug;

class ConditionResolver
{
    public function matchingTarget(Bug $bug): bool
    {
        // check if target is any or matching specific interface ID
        // if any don't need anything - just true (later will take care of it)

        return true;
    }

    public function meetsCondition(Bug $bug): bool
    {
        // check if condition is always or is meeting criteria
        // if Always - return true
        // get needed data for different types of comparsion
        // compare

        return true;
    }
}
