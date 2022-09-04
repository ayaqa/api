<?php

namespace AyaQA\Support\BugFramework\Value\Base;

use AyaQA\Support\BugFramework\Value\Contract\BugKeyValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;

abstract class AbstractBugKeyValue extends AbstractBugValue implements BugKeyValue
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
        if ($value instanceof BugKeyValue) {
            return parent::sameValueAs($value) && $this->sameKeyAs($value);
        }

        return false;
    }

    public function sameKeyAs(BugValue $value): bool
    {
        if ($value instanceof BugKeyValue) {
            return $this->key() === $value->key();
        }

        return false;
    }
}
