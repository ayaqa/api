<?php

namespace AyaQA\Support\Bug\Manifest\Target;

use AyaQA\Enum\SectionId;
use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Bug\HideUIElementBug;
use AyaQA\Support\Bug\Manifest\Bug\ModifyRequestParameter;
use AyaQA\Support\Bug\Manifest\Contract\BugTarget;
use AyaQA\Support\Bug\Manifest\Dto\KeyLabelDTO;

class CheckboxTwoTarget implements BugTarget
{
    public function getId(): string
    {
        return BugMapper::getTargetId(self::class);
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
            KeyLabelDTO::from('2g', 'Param: 2G (bool)'),
            KeyLabelDTO::from('3g', 'Param: 3G (bool)'),
            KeyLabelDTO::from('4g', 'Param: 4G (bool)'),
            KeyLabelDTO::from('5g', 'Param: 5G (bool)'),
        ];
    }

    public function getSupportedBugs(): array
    {
        return [
            HideUIElementBug::class,
            ModifyRequestParameter::class
        ];
    }
}
