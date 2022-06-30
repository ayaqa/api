<?php

namespace AyaQA\Support;

use AyaQA\Support\Bug\Condition\Enum\BugOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Condition\Enum\Conjunction;
use AyaQA\Support\Bug\Condition\Factory\ConditionFactory;

class BugPlayground
{
    public function define()
    {
        $factory = new ConditionFactory();

        $condition = $factory->createCondition(
            BugTarget::PARAM_VALUE,
            BugOperator::IS,
            'angel'
        );

        $condition2 = $factory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $group = $factory->createGroup(Conjunction::AND, $condition, $condition2);
    }
}
