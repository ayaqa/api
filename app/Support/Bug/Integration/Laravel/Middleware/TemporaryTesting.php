<?php

namespace AyaQA\Support\Bug\Integration\Laravel\Middleware;

use AyaQA\Support\Bug\Bug;
use AyaQA\Support\Bug\Bugs;
use AyaQA\Support\Bug\Condition\Enum\BugOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Condition\Enum\Conjunction;
use AyaQA\Support\Bug\Condition\Factory\ConditionFactory;
use AyaQA\Support\Bug\Support\Value\Uuid;

class TemporaryTesting
{
    public function __construct(
        private ConditionFactory $conditionFactory
    ) {}

    public function handle($request, \Closure $next): mixed
    {
        $this->bootConditions();

        return $next($request);
    }


    protected function bootConditions()
    {
        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
        );

        $bug = new Bug(Uuid::create(), $group);
        $bugGroup = new Bugs([$bug]);
    }
}
