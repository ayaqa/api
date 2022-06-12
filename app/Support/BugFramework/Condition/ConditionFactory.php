<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Condition\Conditions\EqualCondition;
use AyaQA\Support\BugFramework\Condition\Conditions\NotCondition;
use AyaQA\Support\BugFramework\Contract\BugCondition;
use AyaQA\Support\BugFramework\Contract\BugValue;

class ConditionFactory
{
    public function create(string $condition, BugValue $value): BugCondition
    {
        $type = Condition::from($condition);

        return $this->createByType($type, $value);
    }

    public function createByType(Condition $type, BugValue $value): BugCondition
    {
        return match ($type) {
            Condition::EQUAL => new EqualCondition($value),
            Condition::NOT_EQUAL => new NotCondition(new EqualCondition($value)),
            default => throw new \RuntimeException('Not supported by generic method. Use custom one.')
        };
    }
}
