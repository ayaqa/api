<?php

namespace AyaQA\Support\BugFramework\Context\Event;

use AyaQA\Support\BugFramework\AppStep;

class AppStepUpdated
{
    public function __construct(
        public readonly AppStep $step,
    ){}

    public static function toStep(AppStep $step): self
    {
        return new static($step);
    }
}
