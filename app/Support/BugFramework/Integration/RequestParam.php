<?php

namespace AyaQA\Support\BugFramework\Integration;

enum RequestParam: string
{
    case RESOURCE_ID = 'resourceId';

    public function asParamKey(): string
    {
        return $this->value;
    }
}
