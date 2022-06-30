<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\Action\Actions\ReturnErrorAction;
use AyaQA\Support\BugFramework\BugManager;
use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\Conjunction;
use AyaQA\Support\BugFramework\Condition\Operator;
use AyaQA\Support\BugFramework\Condition\ConditionFactory;
use AyaQA\Support\BugFramework\Rule\BugRule;
use AyaQA\Support\BugFramework\Rule\BugRules;
use AyaQA\Support\BugFramework\Value\Parameter;
use AyaQA\Support\BugFramework\Value\ResourceId;

class BugsInRequest
{
    public function __construct(
        private BugManager $bugManager,
        private BugRules $bugRules
    ) {}

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next): mixed
    {
        $this->fakeBugRules();

        $this->bugManager->boot();

        return $next($request);
    }

    private function fakeBugRules()
    {
        $parameter = new Parameter('name', 'angel');
        $parameter2 = new Parameter('name', 'legna');

        $conditionFactory = new ConditionFactory();
        $operator = $conditionFactory->createOperatorByType(Operator::EQUAL, BugTarget::PARAMETER, $parameter);
        $operator2 = $conditionFactory->createOperatorByType(Operator::NOT_EQUAL, BugTarget::PARAMETER, $parameter2);

        $condition = $conditionFactory->create(Conjunction::OR, $operator, $operator2);

        $action = new ReturnErrorAction();

        $rule = new BugRule(BugTarget::PARAMETER, $condition, $action);
        $this->bugRules->add($rule);
    }
}
