<?php

namespace AyaQA\Abstracts;

use AyaQA\Contracts\ModelFactory;

abstract class Factory implements ModelFactory
{
    public static function make(): static
    {
        return new static();
    }
}
