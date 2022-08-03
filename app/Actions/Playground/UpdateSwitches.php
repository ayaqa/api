<?php

namespace AyaQA\Actions\Playground;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\CommandAction;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Exceptions\Playground\ResourceNotFound;

class UpdateSwitches implements CommandAction
{
    use Invocable;

    public function __construct(
        private GetSwitches $getSwitchesAction
    ){}

    public function handle(SectionId $sectionId, ElementType $elementType, array $data)
    {
        $switches = $this->getSwitchesAction->handle($sectionId, $elementType);

        foreach ($data as $key => $state) {
            $switch = $switches->firstWhere('key', '=', $key);

            if (null === $switch) {
                throw ResourceNotFound::inDB($sectionId->get(), $elementType);
            }

            $switch->value = (bool) $state;
            $switch->save();
        }

        return $switches;
    }
}
