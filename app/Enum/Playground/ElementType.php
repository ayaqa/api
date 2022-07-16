<?php

namespace AyaQA\Enum\Playground;

use AyaQA\Models\Playground\Checkbox;
use AyaQA\Models\Playground\Toggle;
use Illuminate\Database\Eloquent\Builder;

enum ElementType
{
    case CHECKBOX;
    case TOGGLE;

    public function getQuery(): Builder
    {
        return match ($this) {
            self::CHECKBOX => Checkbox::query(),
            self::TOGGLE => Toggle::query(),
        };
    }
}
