<?php

namespace AyaQA\Support\BugFramework;

use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;
use JsonSerializable;

class ConfiguredBugs implements JsonSerializable
{
    public function __construct(
        private array $bugs = []
    ) {
        AssertHelper::isCollectionOfType($bugs, ConfiguredBug::class);
    }

    public function add(ConfiguredBug $bug): self
    {
        $this->bugs[] = $bug;

        return $this;
    }

    public function merge(ConfiguredBug ...$bug): self
    {
        $this->bugs = array_merge($this->bugs, $bug);

        return $this;
    }

    /**
     * @return ConfiguredBug[]
     */
    public function toArray(): array
    {
        return $this->bugs;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
