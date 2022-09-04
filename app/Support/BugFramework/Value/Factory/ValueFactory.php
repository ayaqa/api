<?php

namespace AyaQA\Support\BugFramework\Value\Factory;

use AyaQA\Support\BugFramework\Value\ValueType;

class ValueFactory
{
    public function create(string $type, mixed ...$args)
    {
        $type = ValueType::from($type);

        return $this->createValue($type, ...$args);
    }

    public function createValue(ValueType $type, mixed ...$args)
    {
        $fieldClass = $type->getFieldClass();

        return new $fieldClass(...$args);
    }

    public function createValueCollection(ValueType $type, array $data)
    {
        $collectionClass = $type->getCollectionClass();

        return new $collectionClass($data);
    }
}
