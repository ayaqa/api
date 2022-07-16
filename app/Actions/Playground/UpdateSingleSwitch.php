<?php

namespace AyaQA\Actions\Playground;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\CommandAction;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Exceptions\Playground\ResourceNotFound;

class UpdateSingleSwitch implements CommandAction
{
    use Invocable;

    public function handle(SectionId $sectionId, ElementType $elementType, bool $newState = false): bool
    {
        $switch = $elementType->getQuery()
            ->where('key', '=', $sectionId->get())
            ->firstOr(['*'], fn() => throw ResourceNotFound::inDB($sectionId->get(), $elementType));


        $switch->value = $newState;
        $switch->save();

        return (bool) $switch->value;
    }
}
