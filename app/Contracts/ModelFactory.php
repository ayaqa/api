<?php

namespace AyaQA\Contracts;

interface ModelFactory
{
    public static function make(): static;
}
