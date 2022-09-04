<?php

namespace AyaQA\Support\BugFramework\Support\Validation\Exception;

use AyaQA\Support\BugFramework\Support\Exception\BugException;

class AssertionFailedException extends BugException
{
    public static function notValidClass(string $class): AssertionFailedException
    {
        return new self(
            sprintf(
                'AssertionFailed: %s is not valid class.',
                $class
            )
        );
    }

    public static function notValidType(object $object, string $expectedClass): AssertionFailedException
    {
        return new self(
            sprintf(
                'AssertionFailed: %s is not an object of type %s.',
                get_class($object),
                $expectedClass
            )
        );
    }

    public static function notValidTypeCollectionItem(object $object, string $expectedClass, int $index): AssertionFailedException
    {
        return new self(
            sprintf(
                'AssertionFailed: Collection item %d %s is not %s type.',
                $index,
                get_class($object),
                $expectedClass
            )
        );
    }
}
