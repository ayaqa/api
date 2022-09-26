<?php

namespace AyaQA\Support\BugFramework\Bug\Contract;

use AyaQA\Support\BugFramework\Support\Config;

interface BugAction
{
    public function execute(Config $config): void;
}
