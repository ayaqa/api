<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Value\Parameter;
use AyaQA\Support\BugFramework\Value\ResourceId;
use RuntimeException;

enum BugTarget
{
    case RESOURCE_ID;
    case PAGE_ID;
    case SECTION_ID;
    case PARAMETER;

    public function asValueClass()
    {
        return match ($this) {
            self::RESOURCE_ID => ResourceId::class,
            self::PARAMETER => Parameter::class,

            // @TODO Custom exception
            default => throw new RuntimeException(
                sprintf(
                    'Not found value object class for %s target.',
                    $this->name
                )
            ),
        };
    }

    public function asString(): string
    {
        return $this->name;
    }
}
