<?php

namespace AyaQA\Support\BugFramework\Action\Actions;

use AyaQA\Support\BugFramework\Action\Contract\BugAction;

class ReturnErrorAction implements BugAction
{
    public function execute(array $options = []): mixed
    {
        throw new \RuntimeException('Example action');
    }
}
