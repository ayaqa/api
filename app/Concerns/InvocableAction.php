<?php

namespace AyaQA\Concerns;

trait InvocableAction
{
    public function __invoke()
    {
        return call_user_func_array([$this, 'handle'], func_get_args());
    }
}
