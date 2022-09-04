<?php

namespace AyaQA\Support\BugFramework\Context\Exception;

use AyaQA\Support\BugFramework\Support\Exception\BugException;
use AyaQA\Support\BugFramework\Value\ValueType;

class OverrideContextValueException extends BugException
{
    public static function noOverrideValue(ValueType $bugValue): self
    {
        return new self(
            sprintf('BugField value %s is already set in context', $bugValue->getId())
        );
    }

    public static function noOverrideCollection(ValueType $bugValue): self
    {
        return new self(
            sprintf('BugField collection %s is already set in context', $bugValue->getId())
        );
    }
}
