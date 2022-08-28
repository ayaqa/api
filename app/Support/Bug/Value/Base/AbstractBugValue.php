<?php

namespace AyaQA\Support\Bug\Value\Base;

use AyaQA\Support\Bug\Support\Validation\AssertHelper;
use AyaQA\Support\Bug\Value\Contract\BugValue;

abstract class AbstractBugValue implements BugValue
{
    public function __construct(
        protected string|int $value,
    ) {}

    public function value(): string|int
    {
        return $this->value;
    }

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
