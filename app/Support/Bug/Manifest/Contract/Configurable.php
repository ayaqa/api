<?php

namespace AyaQA\Support\Bug\Manifest\Contract;

use AyaQA\Support\Bug\Manifest\Enum\ConfigurableStep;

interface Configurable
{
    public function configurable(): ConfigurableStep;
}
