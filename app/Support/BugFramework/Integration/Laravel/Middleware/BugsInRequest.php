<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\Action\Type\ReturnErrorAction;
use AyaQA\Support\BugFramework\BugManager;
use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\Condition;
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

        $this->bugManager->bugsInStage();

        return $next($request);
    }

    private function fakeBugRules()
    {
        $parameter = new Parameter('name', 'angel');
        $resourceId = new ResourceId('aaOObb');

        $conditionFactory = new ConditionFactory();
        $condition = $conditionFactory->createByType(Condition::EQUAL, $resourceId);

        $action = new ReturnErrorAction();

        $rule = new BugRule(BugTarget::RESOURCE_ID, $condition, $action);
        $this->bugRules->add($rule);
    }
}
