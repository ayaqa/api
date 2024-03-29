<?php

namespace AyaQA\Actions\Playground;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\QueryAction;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Exceptions\Playground\ResourceNotFound;

class GetSwitch implements QueryAction
{
    use Invocable;

    public function handle(SectionId $sectionId, ElementType $elementType): bool
    {
        $switch = $elementType->getQuery()
            ->where('key', '=', $sectionId->getId())
            ->firstOr(['*'], fn() => throw ResourceNotFound::inDB($sectionId->getId(), $elementType));

        return (bool) $switch->value;
    }
}
