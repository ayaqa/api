<?php

namespace AyaQA\Support\BugFramework\Manifest\Contract;

use AyaQA\Support\BugFramework\Support\ConfigType;

interface HasConfigType
{
    public function getConfigType(): ConfigType;
}
