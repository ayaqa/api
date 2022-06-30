<?php

namespace AyaQA\Support\Bug\Integration;

enum ParameterKey: string
{
    case PAGE_ID = 'pageId';

    public function asKey(): string
    {
        return $this->value;
    }
}
