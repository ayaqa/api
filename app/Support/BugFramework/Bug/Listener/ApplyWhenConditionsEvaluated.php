<?php

namespace AyaQA\Support\BugFramework\Bug\Listener;

use AyaQA\Support\BugFramework\Bug\BugManager;
use AyaQA\Support\BugFramework\Condition\Event\ConditionsWereEvaluated;

class ApplyWhenConditionsEvaluated
{
    public function __construct(
        private BugManager $bugManager
    ){}

    public function handle(ConditionsWereEvaluated $event)
    {
        $this->bugManager->apply();
    }
}
