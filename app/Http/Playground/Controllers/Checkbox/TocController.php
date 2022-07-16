<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use AyaQA\Actions\Playground\GetSingleSwitch;
use AyaQA\Actions\Playground\UpdateSingleSwitch;
use AyaQA\Concerns\ResponseTrait;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use Illuminate\Http\Request;

class TocController
{
    use ResponseTrait;

    public function get(GetSingleSwitch $getSingleSwitchAction)
    {
        $result = $getSingleSwitchAction->handle(SectionId::CHECKBOX_01, ElementType::CHECKBOX);

        return $this->respond([
            'accepted' => $result,
            'id'       => SectionId::CHECKBOX_01,
        ]);
    }

    public function set(Request $request, UpdateSingleSwitch $updateSingleSwitchAction)
    {
        $state = $request->post('accepted', false);

        $result = $updateSingleSwitchAction
            ->handle(SectionId::CHECKBOX_01, ElementType::CHECKBOX, $state);

        return $this->respond([
            'accepted' => $result,
            'id'       => SectionId::CHECKBOX_01,
        ]);
    }
}
