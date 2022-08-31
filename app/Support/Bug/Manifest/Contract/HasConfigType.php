<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

use AyaQA\Support\Bug\Manifest\Enum\ConfigType;

interface HasConfigType
{
    public function getConfigType(): ConfigType;
}
