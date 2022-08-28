<?php

namespace AyaQA\Support\Bug\Context\Exception;

use AyaQA\Support\Bug\Support\Exception\BugException;
use AyaQA\Support\Bug\Value\BugValueType;

class OverrideContextValueException extends BugException
{
    public static function noOverrideValue(BugValueType $bugValue): self
    {
        return new self(
            sprintf('BugField value %s is already set in context', $bugValue->asString())
        );
    }

    public static function noOverrideCollection(BugValueType $bugValue): self
    {
        return new self(
            sprintf('BugField collection %s is already set in context', $bugValue->asString())
        );
    }
}
