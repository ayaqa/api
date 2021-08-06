<?php

namespace AyaQA\Core\Http;

abstract class ResponseWrapper
{
    public static function success(array $data): array
    {
        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public static function error(array $data): array
    {
        return array_merge([
            'error' => true,
            'validation' => false,
            'message' => __('Something went wrong.')
        ], $data);
    }

    public static function generic(bool $isSuccessful, array $data): array
    {
        return $isSuccessful ? self::success($data) : self::error($data);
    }
}
