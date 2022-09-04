<?php

namespace AyaQA\Support\BugFramework\Support\Utility;

class CompareHelper
{
    public static function isBool(mixed $value): bool
    {
        return in_array($value, ['true', 'false', true, false]);
    }

    public static function toBool(mixed $value): bool
    {
        if (is_string($value)) {
            return mb_strtolower($value) === 'true';
        }

        if (is_int($value) || is_bool($value)) {
            return (bool) $value;
        }

        return false;
    }
}
