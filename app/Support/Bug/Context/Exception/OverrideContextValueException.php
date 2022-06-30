<?php

namespace AyaQA\Support\Bug\Context\Exception;

use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Support\Exception\BugException;

class OverrideContextValueException extends BugException
{
    public static function noOverrideValue(BugField $bugField): self
    {
        return new self(
            sprintf('BugField value %s is already set in context', $bugField->asString())
        );
    }

    public static function noOverrideCollection(BugField $bugField): self
    {
        return new self(
            sprintf('BugField collection %s is already set in context', $bugField->asString())
        );
    }
}
