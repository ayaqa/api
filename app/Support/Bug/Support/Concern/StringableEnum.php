<?php

namespace AyaQA\Support\Bug\Support\Concern;

trait StringableEnum
{
    public function asString(): string
    {
        return $this->value;
    }
}
