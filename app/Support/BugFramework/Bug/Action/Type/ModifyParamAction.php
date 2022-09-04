<?php

namespace AyaQA\Support\BugFramework\Bug\Action\Type;

use AyaQA\Support\BugFramework\Bug\Contract\BugAction;
use AyaQA\Support\BugFramework\Bug\Enum\ParamType;
use AyaQA\Support\BugFramework\Bug\Event\SetParameter;
use AyaQA\Support\BugFramework\Support\Config;
use function event;

class ModifyParamAction implements BugAction
{
    public function __construct(
        private ParamType $paramType
    ){}

    public function execute(Config $config): void
    {
        event(new SetParameter($this->paramType, $config->getKey(), $config->getValue()));
    }
}
