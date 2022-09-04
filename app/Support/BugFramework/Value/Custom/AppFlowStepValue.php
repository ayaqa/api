<?php

namespace AyaQA\Support\BugFramework\Value\Custom;

use AyaQA\Support\BugFramework\AppFlowStep;
use AyaQA\Support\BugFramework\Value\Base\AbstractBugValue;

class AppFlowStepValue extends AbstractBugValue
{
    public function sameStep(AppFlowStep $step)
    {
        return $this->value() === $step->getId();
    }
}
