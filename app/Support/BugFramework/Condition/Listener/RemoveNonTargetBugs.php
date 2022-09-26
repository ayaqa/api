<?php

namespace AyaQA\Support\BugFramework\Condition\Listener;

use AyaQA\Support\BugFramework\Condition\ConditionManager;
use AyaQA\Support\BugFramework\Context\Event\SetContextValue;
use AyaQA\Support\BugFramework\Value\ValueType;

class RemoveNonTargetBugs
{
    public function __construct(
        private ConditionManager $conditionManager
    ){}

    public function handle(SetContextValue $event): void
    {
        if ($event->type !== ValueType::SECTION_ID) {
            return;
        }

        $this->conditionManager->removeNonTargetBugs();
    }
}
