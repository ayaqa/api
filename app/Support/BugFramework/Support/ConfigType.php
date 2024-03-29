<?php

namespace AyaQA\Support\BugFramework\Support;

use AyaQA\Support\BugFramework\Support\Contract\HasId;

enum ConfigType: string implements HasId
{
    case NONE = 'none';

    case REQ_PARAMETERS = 'req-params';
    case REQ_PARAMETER_KEY = 'req-param-key';

    case RESP_PARAMETERS = 'resp-params';
    case RESP_PARAMETER_KEY = 'resp-param-key';

    case WITH_UI_ELEMENTS = 'ui';
    case WITH_UI_ELEMENT_KEY = 'ui-key';

    case WITH_CUSTOM = 'custom';
    case WITH_CUSTOM_KEY = 'custom-key';

    public function getId(): string
    {
        return $this->value;
    }

    public function isKeyOnly(): bool
    {
        return in_array($this, [
            self::REQ_PARAMETER_KEY,
            self::WITH_UI_ELEMENT_KEY,
            self::WITH_CUSTOM_KEY
        ]);
    }
}
