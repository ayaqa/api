<?php

namespace AyaQA\Support\Bug\Field\Concern;

use AyaQA\Support\Bug\Field\Contract\BugFieldValue;
use AyaQA\Support\Bug\Support\Validation\AssertHelper;

trait ComparableFieldValue
{
    public function sameAs(BugFieldValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugFieldValue::class);

        return $this->sameTypeAs($value) && $this->sameValueAs($value);
    }

    public function sameTypeAs(BugFieldValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugFieldValue::class);

        return static::class === get_class($value);
    }

    public function sameValueAs(BugFieldValue $value): bool
    {
        AssertHelper::isInstanceOf($this, BugFieldValue::class);

        return $this->value() === $value->value();
    }
}
