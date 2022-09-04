<?php

namespace AyaQA\Support\BugFramework\Bug;

use AyaQA\Support\BugFramework\Bug\Enum\ParamType;
use AyaQA\Support\BugFramework\Bug\Service\ParameterReplaceContainer;
use AyaQA\Support\BugFramework\Condition\ConditionManager;

class BugManager
{
    public function __construct(
        private readonly ConditionManager $conditionManager,
        private readonly ParameterReplaceContainer $parameterReplaceContainer
    ){}

    public function apply()
    {
        $bugs = $this->conditionManager->getSatisfiedBugs();
        foreach ($bugs->toArray() as $bug) {
            $bug->bug->apply();
        }
    }

    public function getParametersForReplace(ParamType $type): array
    {
        return $this->parameterReplaceContainer->getParams($type);
    }
}
