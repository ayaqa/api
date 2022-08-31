<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use AyaQA\Actions\Playground\GetSwitch;
use AyaQA\Actions\Playground\UpdateSwitch;
use AyaQA\Concerns\ResponseTrait;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Support\Bug\BugManager;
use AyaQA\Support\Bug\Event\NewContextValue;
use AyaQA\Support\Bug\Value\BugValueType;
use Illuminate\Http\Request;

class TocController
{
    use ResponseTrait;

    public function get(GetSwitch $getSingleSwitchAction)
    {
        event(NewContextValue::from(BugValueType::SECTION_ID, [SectionId::CHECKBOX_01->get()]));

        $result = $getSingleSwitchAction
            ->handle(SectionId::CHECKBOX_01, ElementType::CHECKBOX);

        return $this->respond([
            'accepted' => $result,
            'id'       => SectionId::CHECKBOX_01,
        ]);
    }

    public function set(Request $request, UpdateSwitch $updateSingleSwitchAction)
    {
        event(NewContextValue::from(BugValueType::SECTION_ID, [SectionId::CHECKBOX_01->get()]));

        $state = $request->post('accepted', false);

        $result = $updateSingleSwitchAction
            ->handle(SectionId::CHECKBOX_01, ElementType::CHECKBOX, $state);

        return $this->respond([
            'accepted' => $result,
            'id'       => SectionId::CHECKBOX_01,
        ]);
    }
}
