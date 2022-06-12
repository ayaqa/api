<?php

namespace AyaQA\Support\BugFramework\Value\Concern;

use AyaQA\Support\BugFramework\Contract\BugValue;
use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;

trait ComparableValue
{
    public function sameAs(BugValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugValue::class);

        return $this->sameTypeAs($value) && $this->sameValueAs($value);
    }

    public function sameTypeAs(BugValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugValue::class);

        return static::class === get_class($value);
    }

    public function sameValueAs(BugValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugValue::class);

        return $this->value() === $value->value();
    }
}
