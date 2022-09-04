<?php

namespace AyaQA\Support\BugFramework\Support;

enum ApplicableTo: string
{
    case ANY = 'any';
    case BOTH = 'both';
    case APP = 'app';
    case API = 'api';

    public function get(): string
    {
        return $this->value;
    }

    public static function present(): array
    {
        $return = [];
        foreach ([self::ANY, self::APP, self::API] as $item) {
            $return[] = [
                'id' => $item->get(),
                'text' => $item->get()
            ];
        }

        return $return;
    }
}
