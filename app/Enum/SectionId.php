<?php

namespace AyaQA\Enum;

enum SectionId: string
{
    case CHECKBOX_01 = 'cb-01';
    case CHECKBOX_02 = 'cb-02';
    case CHECKBOX_03 = 'cb-03';

    case TOGGLE_01 = 'tg-01';
    case TOGGLE_02 = 'tg-02';
    case TOGGLE_03 = 'tg-03';

    public function getId(): string
    {
        return $this->value;
    }
}
