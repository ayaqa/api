<?php

namespace AyaQA\Concerns;

use AyaQA\Exceptions\AyaQAException;

trait Invocable
{
    public function __invoke()
    {
        if (false === method_exists($this, 'handle')) {
            throw new AyaQAException(
                sprintf('Invocable expect %s to have handle method.', get_class($this))
            );
        }

        return call_user_func_array([$this, 'handle'], func_get_args());
    }
}
