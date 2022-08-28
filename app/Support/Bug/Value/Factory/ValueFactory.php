<?php

namespace AyaQA\Support\Bug\Value\Factory;

use AyaQA\Support\Bug\Value\BugValueType;

class ValueFactory
{
    public function create(string $type, mixed ...$args)
    {
        $type = BugValueType::from($type);

        return $this->createValue($type, ...$args);
    }

    public function createValue(BugValueType $type, mixed ...$args)
    {
        $fieldClass = $type->getFieldClass();

        return new $fieldClass(...$args);
    }

    public function createValueCollection(BugValueType $type, array $data)
    {
        $collectionClass = $type->getCollectionClass();

        return new $collectionClass($data);
    }
}
