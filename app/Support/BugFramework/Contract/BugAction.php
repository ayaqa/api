<?php

namespace AyaQA\Support\BugFramework\Contract;

interface BugAction
{
    public function execute(array $options = []): mixed;
}
