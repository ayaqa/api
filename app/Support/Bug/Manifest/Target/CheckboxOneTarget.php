<?php

namespace AyaQA\Support\Bug\Manifest\Target;

use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Manifest\Bug\HideUIElementBug;
use AyaQA\Support\Bug\Manifest\Bug\ModifyRequestParameter;
use AyaQA\Support\Bug\Manifest\Contract\BugTarget;
use AyaQA\Support\Bug\Manifest\Dto\KeyLabelDTO;

class CheckboxOneTarget implements BugTarget
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
            KeyLabelDTO::from('accepted', 'Param: accepted (bool)')
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
