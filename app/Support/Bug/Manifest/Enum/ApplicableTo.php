<?php

namespace AyaQA\Support\Bug\Manifest\Enum;

enum ApplicableTo: string
{
    case BOTH = 'both';
    case APP = 'app';
    case API = 'api';

    public function isBoth(): bool
    {
        return $this === self::BOTH;
    }

    public function get(): string
    {
        return $this->value;
    }

    public static function present(): array
    {
        $return = [];
        foreach ([self::BOTH, self::APP, self::API] as $item) {
            $return[] = [
                'id' => $item->get(),
                'text' => $item->get()
            ];
        }

        return $return;
    }
}
