<?php

namespace AyaQA\Support\Bug;

use AyaQA\Support\Bug\Support\Validation\AssertHelper;

class Bugs
{
    public function __construct(
        private array $bugs = []
    ) {
        AssertHelper::isCollectionOfType($bugs, Bug::class);
    }

    public function add(Bug ...$bug): self
    {
        $this->bugs = array_merge($this->bugs, $bug);

        return $this;
    }

    /**
     * @return Bug[]
     */
    public function getBugs(): array
    {
        return $this->bugs;
    }
}
