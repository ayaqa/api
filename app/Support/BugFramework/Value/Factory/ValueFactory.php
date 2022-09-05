<?php

namespace AyaQA\Support\BugFramework\Value\Factory;

use AyaQA\Support\BugFramework\Value\Base\BaseValueCollection;
use AyaQA\Support\BugFramework\Value\Contract\BugValueAndKey;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\ValueType;

class ValueFactory
{
    public function create(string $type, mixed ...$args): BugValue|BugValueAndKey
    {
        $type = ValueType::from($type);

        return $this->createValue($type, ...$args);
    }

    public function createValue(ValueType $type, mixed ...$args): BugValue|BugValueAndKey
    {
        $fieldClass = $type->getFieldClass();

        return new $fieldClass(...$args);
    }

    public function createValueCollection(ValueType $type, array $data = []): BaseValueCollection
    {
        $collectionClass = $type->getCollectionClass();

        return new $collectionClass($data);
    }
}
