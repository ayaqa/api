<?php

namespace AyaQA\Support\BugFramework\Value\Base;

use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

abstract class AbstractBugValue implements BugValue
{
    public function __construct(
        protected string|int|bool $value,
    ) {}

    public function value(): string|int|bool
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

        return mb_strtolower($this->value()) === mb_strtolower($value->value());
    }
}
