<?php

namespace AyaQA\Support\BugFramework\Bug\Listener;

use AyaQA\Support\BugFramework\Bug\Event\SetParameter;
use AyaQA\Support\BugFramework\Bug\Service\ReplacedParameters;

class SetParameterHandler
{
    public function __construct(
        private ReplacedParameters $replaceContainer
    ){}

    public function handle(SetParameter $event): void
    {
        $this->replaceContainer->add($event->paramType, $event->paramKey, $event->paramValue);
    }
}
