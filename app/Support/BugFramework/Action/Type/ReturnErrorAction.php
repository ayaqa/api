<?php

namespace AyaQA\Support\BugFramework\Action\Type;

use AyaQA\Support\BugFramework\Contract\BugAction;

class ReturnErrorAction implements BugAction
{
    public function execute(array $options = []): mixed
    {
        throw new \RuntimeException('Example action');
    }
}
