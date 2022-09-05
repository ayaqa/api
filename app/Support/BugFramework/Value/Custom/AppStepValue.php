<?php

namespace AyaQA\Support\BugFramework\Value\Custom;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Value\Base\BaseValue;

class AppStepValue extends BaseValue
{
    public function sameStep(AppStep $step)
    {
        return $this->value() === $step->getId();
    }
}
