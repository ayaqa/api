<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use AyaQA\Actions\Playground\GetSwitch;
use AyaQA\Actions\Playground\UpdateSwitch;
use AyaQA\Concerns\ResponseTrait;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use AyaQA\Support\BugFramework\Support\Controller\BuggableController;
use Illuminate\Http\Request;

class TocController extends BuggableController
{
    use ResponseTrait;

    public static function getSection(): SectionId
    {
        return SectionId::CHECKBOX_01;
    }

    public function get(GetSwitch $getSingleSwitchAction)
    {
        $result = $getSingleSwitchAction
            ->handle(SectionId::CHECKBOX_01, ElementType::CHECKBOX);

        return $this->respond([
            'accepted' => $result,
            'id'       => SectionId::CHECKBOX_01,
        ]);
    }

    public function set(Request $request, UpdateSwitch $updateSingleSwitchAction)
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
