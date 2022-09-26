<?php

namespace AyaQA\Support\BugFramework\Bug\Listener;

use AyaQA\Support\BugFramework\Bug\BugManager;
use AyaQA\Support\BugFramework\Condition\Event\ConditionsEvaluated;

class ApplyAfterConditionsEval
{
    public function __construct(
        private BugManager $bugManager
    ){}

    public function handle(ConditionsEvaluated $event)
    {
        $this->bugManager->apply();
    }
}
