<?php

namespace AyaQA\Support\BugFramework\Integration;

enum RequestParamType: string
{
    case RESOURCE_ID = 'resourceId';

    public function getParamKey(): string
    {
        return $this->value;
    }
}
