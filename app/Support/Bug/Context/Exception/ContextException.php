<?php

namespace AyaQA\Support\Bug\Context\Exception;

use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Support\Exception\BugException;

class ContextException extends BugException
{
    public static function noValueSet(BugField $field): self
    {
        return new self(
            sprintf('Value %s is not set in context.', $field->asString())
        );
    }

    public static function shouldBeValue(BugField $field): self
    {
        return new self(
            sprintf('BugField %s data should not be set as collection.', $field->asString())
        );
    }

    public static function shouldBeCollection(BugField $field): self
    {
        return new self(
            sprintf('BugField %s data should be set as collection.', $field->asString())
        );
    }
}
