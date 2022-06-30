<?php

namespace AyaQA\Support\BugFramework\Support\Concern;

trait StringableEnum
{
    public function asString(): string
    {
        return $this->value;
    }
}
