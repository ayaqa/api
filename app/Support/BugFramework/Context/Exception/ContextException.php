<?php

namespace AyaQA\Support\BugFramework\Context\Exception;

use AyaQA\Support\BugFramework\Support\Exception\BugException;
use AyaQA\Support\BugFramework\Value\ValueType;

class ContextException extends BugException
{
    public static function notFound(ValueType $value): self
    {
        return new self(
            sprintf('Value %s is not found in context', $value->getId())
        );
    }

    public static function shouldBeValue(ValueType $value): self
    {
        return new self(
            sprintf('BugField %s data should not be set as collection', $value->getId())
        );
    }

    public static function shouldBeCollection(ValueType $value): self
    {
        return new self(
            sprintf('BugField %s data should be set as collection', $value->getId())
        );
    }
}
