<?php

namespace AyaQA\Actions\Playground;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\CommandAction;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Exceptions\Playground\ResourceNotFound;

class UpdateSwitch implements CommandAction
{
    use Invocable;

    public function handle(SectionId $sectionId, ElementType $elementType, bool $newState = false): bool
    {
        $switch = $elementType->getQuery()
            ->where('key', '=', $sectionId->getId())
            ->firstOr(['*'], fn() => throw ResourceNotFound::inDB($sectionId->getId(), $elementType));

        $switch->value = $newState;
        $switch->save();

        return (bool) $switch->value;
    }
}
