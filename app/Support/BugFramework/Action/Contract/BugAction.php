<?php

namespace AyaQA\Support\BugFramework\Action\Contract;

interface BugAction
{
    public function execute(array $options = []): mixed;
}
