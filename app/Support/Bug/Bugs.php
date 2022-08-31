<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Support\Validation\AssertHelper;
use JsonSerializable;

class Bugs implements JsonSerializable
{
    public function __construct(
        private array $bugs = []
    ) {
        AssertHelper::isCollectionOfType($bugs, Bug::class);
    }

    public function add(Bug $bug): self
    {
        $this->bugs[] = $bug;

        return $this;
    }

    public function merge(Bug ...$bug): self
    {
        $this->bugs = array_merge($this->bugs, $bug);

        return $this;
    }

    /**
     * @return Bug[]
     */
    public function asArray(): array
    {
        return $this->bugs;
    }

    public function jsonSerialize(): array
    {
        return $this->asArray();
    }
}
