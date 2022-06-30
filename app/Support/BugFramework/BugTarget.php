<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Support\Concern\StringableEnum;
use AyaQA\Support\BugFramework\Value\Parameter;
use AyaQA\Support\BugFramework\Value\ResourceId;
use RuntimeException;

enum BugTarget: string
{
    use StringableEnum;

    case RESOURCE_ID = 'RESOURCE_ID';
    case PAGE_ID = 'PAGE_ID';
    case SECTION_ID = 'SECTION_ID';
    case PARAMETER = 'PARAMETER';

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
}
