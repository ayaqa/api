<?php

namespace AyaQA\Support\BugFramework\Bug;

use AyaQA\Support\BugFramework\Bug\Action\Type\ModifyParamAction;
use AyaQA\Support\BugFramework\Bug\Contract\BugAction;
use AyaQA\Support\BugFramework\Bug\Enum\ParamType;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyRequestParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\API\ModifyResponseParameter;
use AyaQA\Support\BugFramework\Manifest\Bug\UI\HideUIElementBug;
use AyaQA\Support\BugFramework\Support\Contract\HasId;

enum BugType: string implements HasId
{
    case HIDE_UI_ELEMENT    = 'hide-ui-el';
    case MODIFY_REQ_PARAM   = 'modify-req-param';
    case MODIFY_RESP_PARAM  = 'modify-resp-param';

    public function getId(): string
    {
        return $this->value;
    }

    /**
     * @return class-string
     */
    public function getManifestClass(): string
    {
        return match ($this) {
            self::HIDE_UI_ELEMENT   => HideUIElementBug::class,
            self::MODIFY_REQ_PARAM  => ModifyRequestParameter::class,
            self::MODIFY_RESP_PARAM => ModifyResponseParameter::class
        };
    }

    /**
     * @return BugAction[]
     */
    public function getActions(): array
    {
        return match ($this) {
            self::MODIFY_REQ_PARAM => [
                new ModifyParamAction(ParamType::POST)
            ],
            self::MODIFY_RESP_PARAM => [
                new ModifyParamAction(ParamType::RESPONSE)
            ]
        };
    }
}
