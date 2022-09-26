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

class CheckboxTwoManifestTarget implements BugManifestTarget
{
    public function getId(): string
    {
        return SectionId::CHECKBOX_02->getId();
    }

    public function getText(): string
    {
        return sprintf(
            '%s: %s',
            mb_strtoupper($this->getId()),
            'Technologies'
        );
    }

    public function getUIElements(): array
    {
        return [
            KeyLabelDTO::from('2g', 'Checkbox: 2G'),
            KeyLabelDTO::from('3g', 'Checkbox: 3G'),
            KeyLabelDTO::from('4g', 'Checkbox: 4G'),
            KeyLabelDTO::from('5g', 'Checkbox: 5G'),
        ];
    }

    public function getRequestParams(): array
    {
        return [
            KeyLabelDTO::from('2g', '2G (bool)'),
            KeyLabelDTO::from('3g', '3G (bool)'),
            KeyLabelDTO::from('4g', '4G (bool)'),
            KeyLabelDTO::from('5g', '5G (bool)'),
        ];
    }

    public function getResponseParams(): array
    {
        return [
            KeyLabelDTO::from('id', 'id (string)'),
            KeyLabelDTO::from('radio.2g', '2G (bool)'),
            KeyLabelDTO::from('radio.3g', '3G (bool)'),
            KeyLabelDTO::from('radio.4g', '4G (bool)'),
            KeyLabelDTO::from('radio.5g', '5G (bool)'),
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
