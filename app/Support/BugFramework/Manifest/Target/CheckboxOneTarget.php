<?php

namespace AyaQA\Support\BugFramework\Manifest\Target;

use AyaQA\Enum\SectionId;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyRequestParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyResponseParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\UI\HideUIElementBug;
use AyaQA\Support\BugFramework\Manifest\Contract\BugTarget;
use AyaQA\Support\BugFramework\Manifest\Dto\KeyLabelDTO;

class CheckboxOneTarget implements BugTarget
{
    public function getId(): string
    {
        return SectionId::CHECKBOX_01->getId();
    }

    public function getText(): string
    {
        return sprintf(
            '%s: %s',
            mb_strtoupper($this->getId()),
            'Terms and conditions'
        );
    }

    public function getUIElements(): array
    {
        return [
            KeyLabelDTO::from('accepted', 'Checkbox: Agree with terms & conditions')
        ];
    }

    public function getRequestParams(): array
    {
        return [
            KeyLabelDTO::from('accepted', 'accepted (bool)')
        ];
    }

    public function getResponseParams(): array
    {
        return [
            KeyLabelDTO::from('accepted', 'accepted (bool)')
        ];
    }

    public function getSupportedBugs(): array
    {
        return [
            HideUIElementBug::class,
            ModifyRequestParameter::class,
            ModifyResponseParameter::class
        ];
    }
}
