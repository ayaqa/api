<?php

namespace AyaQA\Exceptions\Playground;

use AyaQA\Enum\Playground\ElementType;
use AyaQA\Exceptions\AyaQAException;

class ResourceNotFound extends AyaQAException
{
    public static function inDB(string $identifier, ElementType $elementType): static
    {
        throw new static(
            __('Identifier :id was not found it db :el', ['id' => $identifier, 'el' => $elementType->name])
        );
    }
}
