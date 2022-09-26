<?php

namespace AyaQA\Support\BugFramework\Value\Base;

use AyaQA\Support\BugFramework\Value\Contract\BugValueAndKey;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

abstract class BaseValueAndKey extends BaseValue implements BugValueAndKey
{
    public function __construct(
        protected string $key,
        string|int|bool $value,
    ) {
        parent::__construct($value);
    }

    public function key(): string
    {
        return $this->key;
    }

    public function sameValueAs(BugValue $value): bool
    {
        if ($value instanceof BugValueAndKey) {
            return parent::sameValueAs($value) && $this->sameKeyAs($value);
        }

        return false;
    }

    public function sameKeyAs(BugValue $value): bool
    {
        if ($value instanceof BugValueAndKey) {
            return $this->key() === $value->key();
        }

        return false;
    }
}
