<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use AyaQA\Actions\Playground\GetSwitch;
use AyaQA\Actions\Playground\GetSwitches;
use AyaQA\Actions\Playground\UpdateSwitch;
use AyaQA\Actions\Playground\UpdateSwitches;
use AyaQA\Concerns\ResponseTrait;
use AyaQA\Data\DataTransferObject\Playground\Checkbox\RemindersDTO;
use AyaQA\Enum\Playground\ElementType;
use AyaQA\Enum\SectionId;
use Illuminate\Http\Request;

class RemindersController
{
    use ResponseTrait;

    public function get(GetSwitch $getSwitchAction, GetSwitches $getSwitchesAction)
    {
        $reminders = $getSwitchAction->handle(SectionId::CHECKBOX_03, ElementType::CHECKBOX);
        $switches = $getSwitchesAction->handle(SectionId::CHECKBOX_03, ElementType::CHECKBOX);

        $dto = RemindersDTO::fromCollection($reminders, $switches);

        return $this->respond($dto->asResponse());
    }

    public function set(Request $request, UpdateSwitch $updateSwitchAction, UpdateSwitches $updateSwitchesAction)
    {
        $dto = RemindersDTO::fromRequest($request);

        $reminders = $updateSwitchAction->handle(SectionId::CHECKBOX_03, ElementType::CHECKBOX, $dto->isReminderEnabled());
        $switches = $updateSwitchesAction->handle(SectionId::CHECKBOX_03, ElementType::CHECKBOX, $dto->getChannels());

        $dto = RemindersDTO::fromCollection($reminders, $switches);

        return $this->respond($dto->asResponse());
    }
}
