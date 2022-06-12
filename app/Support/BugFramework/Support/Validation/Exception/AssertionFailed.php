<?php

namespace AyaQA\Support\BugFramework\Support\Validation\Exception;

use RuntimeException;

class AssertionFailed extends RuntimeException
{
    public static function notValidClass(string $class): AssertionFailed
    {
        return new self(
            sprintf(
                'AssertionFailed: %s is not valid class.',
                $class
            )
        );
    }

    public static function notValidType(object $object, string $expectedClass): AssertionFailed
    {
        return new self(
            sprintf(
                'AssertionFailed: %s is not an object of type %s.',
                get_class($object),
                $expectedClass
            )
        );
    }

    public static function notValidTypeCollectionItem(object $object, string $expectedClass, int $index): AssertionFailed
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
