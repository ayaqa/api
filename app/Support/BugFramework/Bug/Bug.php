<?php

namespace AyaQA\Support\BugFramework\Bug;

use AyaQA\Support\BugFramework\Bug\Action\ActionGroup;
use AyaQA\Support\BugFramework\Support\Config;

class Bug
{
    private bool $isApplied = false;

    public function __construct(
        private readonly string $id,
        private readonly Config $config,
        private readonly ActionGroup $actionGroup,
    ){}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return bool
     */
    public function isApplied(): bool
    {
        return $this->isApplied;
    }

    public function apply(): void
    {
        // skip applied
        if ($this->isApplied()) {
            return;
        }

        foreach ($this->actionGroup->getActions() as $action) {
            $action->execute($this->getConfig());
            $this->isApplied = true;
        }
    }
}
