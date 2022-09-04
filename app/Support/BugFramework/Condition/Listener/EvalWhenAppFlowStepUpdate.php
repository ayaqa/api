<?php

namespace AyaQA\Support\BugFramework\Condition\Listener;

use AyaQA\Support\BugFramework\Condition\ConditionManager;
use AyaQA\Support\BugFramework\Condition\Event\ConditionsWereEvaluated;
use AyaQA\Support\BugFramework\Context\Event\AppFlowStepUpdated;

class EvalWhenAppFlowStepUpdate
{
    public function __construct(
        private ConditionManager $conditionManager
    ){}

    public function handle(AppFlowStepUpdated $event)
    {
        $this->conditionManager->evaluate();

        event(new ConditionsWereEvaluated());
    }
}
