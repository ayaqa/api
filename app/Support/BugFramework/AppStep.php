<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Support\Contract\HasId;

enum AppStep: string implements HasId
{
    case PRE_CONTROLLER = 'preController';
    case POST_CONTROLLER = 'postController';

    case PRE_SAVE = 'preSave';
    case POST_SAVE = 'postSave';

    case PRE_VALIDATION = 'preValidation';
    case POST_VALIDATION = 'postValidation';

    public function getId(): string
    {
        return $this->value;
    }
}
