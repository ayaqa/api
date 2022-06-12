<?php

namespace AyaQA\Support;

use AyaQA\Support\BugFramework\Action\Type\ReturnErrorAction;
use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Condition\ConditionFactory;
use AyaQA\Support\BugFramework\Condition\Condition;
use AyaQA\Support\BugFramework\Rule\BugRule;
use AyaQA\Support\BugFramework\Rule\BugRules;
use AyaQA\Support\BugFramework\Value\Parameter;
use AyaQA\Support\BugFramework\Value\ResourceId;


class BugPlayground
{
    public function define()
    {
        $resource = new ResourceId('AA-32');
        $parameter = new Parameter('name', 'angel');

        $conditionFactory = new ConditionFactory();
        $condition = $conditionFactory->createByType(Condition::EQUAL_TO, $resource);

        $action = new ReturnErrorAction();

        $rules = new BugRules();

        $rule = new BugRule(BugTarget::RESOURCE_ID, $condition, $action);
        $rules->add($rule);
    }
}
