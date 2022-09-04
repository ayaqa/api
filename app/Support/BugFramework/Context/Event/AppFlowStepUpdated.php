<?php

namespace AyaQA\Support\BugFramework\Context\Event;

use AyaQA\Support\BugFramework\AppFlowStep;

class AppFlowStepUpdated
{
    public function __construct(
        public readonly AppFlowStep $step,
    ){}

    public static function toStep(AppFlowStep $step): self
    {
        return new static($step);
    }
}
