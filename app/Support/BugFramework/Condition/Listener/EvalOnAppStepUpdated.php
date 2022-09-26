<?php

namespace AyaQA\Support\BugFramework\Condition\Listener;

use AyaQA\Support\BugFramework\Condition\ConditionManager;
use AyaQA\Support\BugFramework\Condition\Event\ConditionsEvaluated;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;

class EvalOnAppStepUpdated
{
    public function __construct(
        private ConditionManager $conditionManager
    ){}

    public function handle(AppStepUpdated $event)
    {
        $this->conditionManager->evaluate();

        event(new ConditionsEvaluated());
    }
}
