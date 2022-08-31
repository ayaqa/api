<?php

namespace AyaQA\Support\Bug\Listener;

use AyaQA\Support\Bug\Context\BugContextSetter;
use AyaQA\Support\Bug\Event\NewContextValue;

class NewContextValueHandler
{
    public function __construct(
        private readonly BugContextSetter $contextSetter
    ){}

    public function handle(NewContextValue $event)
    {
        $this->contextSetter->set(
            $event->type,
            $event->data,
            $event->overrideIfSet
        );
    }
}
