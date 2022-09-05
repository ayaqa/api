<?php

namespace AyaQA\Support\BugFramework\Support\Concern;

use AyaQA\Support\BugFramework\Support\Contract\hasArrayRepresentation;

trait Arrayable
{
    public function jsonSerialize(): array
    {
        if ($this instanceof hasArrayRepresentation) {
            return $this->toArray();
        }

        return [];
    }
}
