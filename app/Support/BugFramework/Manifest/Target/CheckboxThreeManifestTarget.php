<?php

namespace AyaQA\Support\BugFramework\Manifest\Target;

use AyaQA\Enum\SectionId;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyRequestParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyResponseParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\UI\DetachUISaveButton;
use AyaQA\Support\BugFramework\Manifest\Bug\UI\HideUIElement;
use AyaQA\Support\BugFramework\Manifest\Bug\UI\UpdateUILabel;
use AyaQA\Support\BugFramework\Manifest\Contract\BugManifestTarget;
use AyaQA\Support\BugFramework\Manifest\Dto\KeyLabelDTO;

class CheckboxThreeManifestTarget implements BugManifestTarget
{
    public function getId(): string
    {
        return SectionId::CHECKBOX_03->getId();
    }

    public function getText(): string
    {
        return sprintf(
            '%s: %s',
            mb_strtoupper($this->getId()),
            'Reminders'
        );
    }

    public function getUIElements(): array
    {
        return [
            KeyLabelDTO::from('reminders', 'Checkbox: Remind about appointment'),
            KeyLabelDTO::from('email', 'Checkbox: via Email'),
            KeyLabelDTO::from('sms', 'Checkbox: via SMS'),
            KeyLabelDTO::from('app', 'Checkbox: via App'),
        ];
    }

    public function getRequestParams(): array
    {
        return [
            KeyLabelDTO::from('reminders', 'Reminders (bool)'),
            KeyLabelDTO::from('email', 'Email (bool)'),
            KeyLabelDTO::from('sms', 'SMS (bool)'),
            KeyLabelDTO::from('app', 'APP (bool)'),
        ];
    }

    public function getResponseParams(): array
    {
        return [
            KeyLabelDTO::from('id', 'id (string)'),
            KeyLabelDTO::from('reminders', 'Reminders (bool)'),
            KeyLabelDTO::from('channels.email', 'via Email (bool)'),
            KeyLabelDTO::from('channels.sms', 'via SMS (bool)'),
            KeyLabelDTO::from('channels.app', 'via App (bool)'),
        ];
    }

    public function getSupportedBugs(): array
    {
        return [
            HideUIElement::class,
            DetachUISaveButton::class,
            UpdateUILabel::class,
            ModifyRequestParameter::class,
            ModifyResponseParameter::class,
        ];
    }
}
