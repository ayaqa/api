<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use AyaQA\Actions\Playground\GetSwitches;
use AyaQA\Actions\Playground\UpdateSwitches;
use AyaQA\Concerns\ResponseTrait;
use AyaQA\Data\DataTransferObject\Playground\Checkbox\TechnologiesDTO;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use Illuminate\Http\Request;

class TechnologiesController
{
    use ResponseTrait;

    public function get(GetSwitches $getSwitchesAction)
    {
        $collection = $getSwitchesAction
            ->handle(SectionId::CHECKBOX_02, ElementType::CHECKBOX);

        $dto = TechnologiesDTO::fromCollection($collection);

        return $this->respond($dto->asResponse());
    }

    public function set(Request $request, UpdateSwitches $updateSwitchesAction)
    {
        $dto = TechnologiesDTO::fromRequest($request);

        $collection = $updateSwitchesAction
            ->handle(SectionId::CHECKBOX_02, ElementType::CHECKBOX, $dto->asArray());

        $dto = TechnologiesDTO::fromCollection($collection);

        return $this->respond($dto->asResponse());
    }
}
