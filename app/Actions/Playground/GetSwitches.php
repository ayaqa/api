<?php

namespace AyaQA\Actions\Playground;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\QueryAction;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Exceptions\Playground\ResourceNotFound;
use Illuminate\Database\Eloquent\Collection;

class GetSwitches implements QueryAction
{
    use Invocable;

    public function handle(SectionId $sectionId, ElementType $elementType): Collection
    {
        $collection = $elementType->getQuery()
            ->where('group', '=', $sectionId->getId())
            ->get();

        if ($collection->isEmpty()) {
            throw ResourceNotFound::inDB($sectionId->getId(), $elementType);
        }

        return $collection;
    }
}
