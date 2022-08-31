<?php

namespace AyaQA\Support\Bug\Support\Utility;

class CompareHelper
{
    public static function isBool(mixed $value): bool
    {
        return in_array($value, [1, 0, '1', '0', 'true', 'false', true, false]);
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
