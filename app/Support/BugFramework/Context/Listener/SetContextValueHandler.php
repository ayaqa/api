<?php

namespace AyaQA\Support\BugFramework\Context\Listener;

use AyaQA\Support\BugFramework\Context\BugContextSetter;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;
use AyaQA\Support\BugFramework\Context\Event\SetContextValue;
use AyaQA\Support\BugFramework\Value\ValueType;

class SetContextValueHandler
{
    public function __construct(
        private readonly BugContextSetter $contextSetter
    ){}

    public function handleGeneric(SetContextValue $event)
    {
        $this->contextSetter->set(
            $event->type,
            $event->data,
            $event->overrideIfSet
        );
    }

    public function handleAppFlow(AppStepUpdated $event)
    {
        $this->contextSetter->set(
            ValueType::APP_STEP,
            [$event->step->getId()],
            true
        );
    }
}
