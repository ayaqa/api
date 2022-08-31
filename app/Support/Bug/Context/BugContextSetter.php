<?php

namespace AyaQA\Support\Bug\Context;

use AyaQA\Support\Bug\Value\BugValueType;
use AyaQA\Support\Bug\Value\Contract\BugValue;
use AyaQA\Support\Bug\Value\Contract\BugValueCollection;
use AyaQA\Support\Bug\Value\Factory\ValueFactory;

class BugContextSetter
{
    public function __construct(
        private ValueFactory $factory,
        private BugContext $context,
    ){}

    public function set(BugValueType $type, array $data, bool $overrideIfSet = false): self
    {
        if (false === $type->hasCollection()) {
            $value = $this->createValue($type, ...$data);
        } else {
            $value = $this->createCollection($type, $data);
        }

        $this->context->set($type, $value, $overrideIfSet);

        return $this;
    }

    private function createValue(BugValueType $type, mixed ...$args): BugValue
    {
        // @TODO input data validation
        return $this->factory->createValue($type, ...$args);
    }

    private function createCollection(BugValueType $type, array $data): BugValueCollection
    {
        // @TODO input data validation
        $values = [];
        foreach ($data as $key => $val) {
            $values[] = $this->factory->createValue($type, $key, $val);
        }

        return $this->factory->createValueCollection($type, $values);
    }
}
