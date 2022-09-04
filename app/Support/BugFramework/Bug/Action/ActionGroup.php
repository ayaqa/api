<?php

namespace AyaQA\Support\BugFramework\Bug\Action;

use AyaQA\Support\BugFramework\Bug\Contract\BugAction;

class ActionGroup
{
    /** @var BugAction[] */
    private array $actions = [];

    /**
     * @param BugAction ...$actions
     * @return static
     */
    public static function from(BugAction ...$actions): self
    {
        $self = new self();
        $self->actions = $actions;

        return $self;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}
