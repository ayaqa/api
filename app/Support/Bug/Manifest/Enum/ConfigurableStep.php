<?php

namespace AyaQA\Support\Bug\Manifest\Enum;

enum ConfigurableStep: string
{
    case NONE = 'none';
    case WITH_PARAMETERS = 'params';
    case WITH_PARAMETER_KEY = 'param-key';

    case WITH_UI_ELEMENTS = 'ui';
    case WITH_UI_ELEMENT_KEY = 'ui-key';

    case WITH_CUSTOM = 'custom';
    case WITH_CUSTOM_KEY = 'custom-key';

    public function get(): string
    {
        return $this->value;
    }
}
