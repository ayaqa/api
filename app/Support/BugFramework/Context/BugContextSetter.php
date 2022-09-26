<?php

namespace AyaQA\Support\BugFramework\Context;

use AyaQA\Support\BugFramework\Value\ValueType;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValueCollection;
use AyaQA\Support\BugFramework\Value\Factory\ValueFactory;

class BugContextSetter
{
    public function __construct(
        private ValueFactory $factory,
        private BugContext $context,
    ){}

    public function set(ValueType $type, array $data, bool $overrideIfSet = false): self
    {
        if (false === $type->hasCollection()) {
            $value = $this->createValue($type, ...$data);
        } else {
            $value = $this->createCollection($type, $data);
        }

        $this->context->set($type, $value, $overrideIfSet);

        return $this;
    }

    private function createValue(ValueType $type, mixed ...$args): BugValue
    {
        // @TODO input data validation ??
        return $this->factory->createValue($type, ...$args);
    }

    private function createCollection(ValueType $type, array $data): BugValueCollection
    {
        // @TODO input data validation ??
        $collection = $this->factory->createValueCollection($type);
        foreach ($data as $key => $val) {
            $collection->append($this->factory->createValue($type, $key, $val));
        }

        return $collection;
    }
}
