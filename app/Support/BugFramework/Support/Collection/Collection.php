<?php

namespace AyaQA\Support\BugFramework\Support\Collection;

use ArrayObject;
use AyaQA\Support\BugFramework\Support\Concern\Arrayable;
use AyaQA\Support\BugFramework\Support\Contract\HasToArray;
use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;

abstract class Collection extends ArrayObject implements HasToArray
{
    use Arrayable;

    public function __construct(array $array = [])
    {
        AssertHelper::isCollectionOfType($array, static::isCollectionOf());

        parent::__construct($array);
    }

    /**
     * @return class-string
     */
    abstract public static function isCollectionOf(): string;

    public function append(mixed $value): void
    {
        AssertHelper::isInstanceOf($value, static::isCollectionOf());

        parent::append($value);
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        AssertHelper::isInstanceOf($value, static::isCollectionOf());

        parent::offsetSet($key, $value);
    }

    public function toArray(): array
    {
        return $this->getArrayCopy();
    }
}
