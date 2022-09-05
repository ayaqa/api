<?php

namespace AyaQA\Support\BugFramework\Value\Base;

use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

abstract class BaseValue implements BugValue
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
        return $this->sameTypeAs($value) && $this->sameValueAs($value);
    }

    public function sameTypeAs(BugValue $value): bool
    {
        return static::class === get_class($value);
    }

    public function sameValueAs(BugValue $value): bool
    {
        if (is_string($value->value()) && is_string($this->value())) {
            return mb_strtolower($this->value()) === mb_strtolower($value->value());
        }

        return $this->value() === $value->value();
    }
}
