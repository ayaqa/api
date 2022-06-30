<?php

namespace AyaQA\Support\Bug\Support\Validation;

use AyaQA\Support\Bug\Support\Validation\Exception\AssertionFailed;
use Throwable;

class AssertHelper
{
    public static function isClass(string $class): void
    {
        self::throwIfNot(class_exists($class) || interface_exists($class), AssertionFailed::notValidClass($class));
    }

    public static function isInstanceOf(object $object, string $classType, Throwable $throwable = null): void
    {
        self::isClass($classType);
        self::throwIfNot(
            $object instanceof $classType,
            $throwable ?? AssertionFailed::notValidType($object, $classType)
        );
    }

    public static function isCollectionOfType(array $items, string $classType): void
    {
        foreach ($items as $idx => $item) {
            self::isInstanceOf(
                $item,
                $classType,
                AssertionFailed::notValidTypeCollectionItem(
                    $item,
                    $classType,
                    $idx,
                )
            );
        }
    }

    /**
     * @throws AssertionFailed
     */
    public static function throwIf(bool $condition, AssertionFailed $throwable): void
    {
        if ($condition) {
            throw $throwable;
        }
    }

    /**
     * @throws AssertionFailed
     */
    public static function throwIfNot(bool $condition, AssertionFailed $exception): void
    {
        self::throwIf(!$condition, $exception);
    }
}
