<?php

namespace AyaQA\Support\BugFramework\Support;

use AyaQA\Support\BugFramework\Support\Contract\HasId;

enum ApplicableTo: string implements HasId
{
    case ANY = 'any';
    case BOTH = 'both';
    case APP = 'app';
    case API = 'api';

    public function getId(): string
    {
        return $this->value;
    }

    public static function present(): array
    {
        $return = [];
        foreach ([self::ANY, self::APP, self::API] as $item) {
            $return[] = [
                'id' => $item->getId(),
                'text' => $item->getId()
            ];
        }

        return $return;
    }
}
