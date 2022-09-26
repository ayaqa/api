<?php

namespace AyaQA\Support\BugFramework\Support\Validation;

use AyaQA\Support\BugFramework\Support\Validation\Exception\AssertionFailedException;
use Throwable;

class AssertHelper
{
    public static function isClass(string $class): void
    {
        self::throwIfNot(class_exists($class) || interface_exists($class), AssertionFailedException::notValidClass($class));
    }

    public static function isInstanceOf(object $object, string $classType, Throwable $throwable = null): void
    {
        self::isClass($classType);
        self::throwIfNot(
            $object instanceof $classType,
            $throwable ?? AssertionFailedException::notValidType($object, $classType)
        );
    }

    public static function isCollectionOfType(array $items, string $classType): void
    {
        foreach ($items as $idx => $item) {
            self::isInstanceOf(
                $item,
                $classType,
                AssertionFailedException::notValidTypeCollectionItem(
                    $item,
                    $classType,
                    $idx,
                )
            );
        }
    }

    /**
     * @throws AssertionFailedException
     */
    public static function throwIf(bool $condition, AssertionFailedException $throwable): void
    {
        if ($condition) {
            throw $throwable;
        }
    }

    /**
     * @throws AssertionFailedException
     */
    public static function throwIfNot(bool $condition, AssertionFailedException $exception): void
    {
        self::throwIf(!$condition, $exception);
    }
}
