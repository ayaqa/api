<?php

namespace AyaQA\Support\Bug\Context\Exception;

use AyaQA\Support\Bug\Support\Exception\BugException;
use AyaQA\Support\Bug\Value\BugValueType;

class ContextException extends BugException
{
    public static function notFound(BugValueType $value): self
    {
        return new self(
            sprintf('Value %s is not found in context', $value->asString())
        );
    }

    public static function shouldBeValue(BugValueType $value): self
    {
        return new self(
            sprintf('BugField %s data should not be set as collection', $value->asString())
        );
    }

    public static function shouldBeCollection(BugValueType $value): self
    {
        return new self(
            sprintf('BugField %s data should be set as collection', $value->asString())
        );
    }
}
