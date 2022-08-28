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

    public function set(BugValueType $field, array $data): self
    {
        if (false === $field->hasCollection()) {
            $value = $this->createValue($field, ...$data);
        } else {
            $value = $this->createCollection($field, $data);
        }

        $this->context->set($field, $value, false);

        return $this;
    }

    private function createValue(BugValueType $field, mixed ...$args): BugValue
    {
        // @TODO input data validation
        return $this->factory->createValue($field, ...$args);
    }

    private function createCollection(BugValueType $field, array $data): BugValueCollection
    {
        // @TODO input data validation
        $values = [];
        foreach ($data as $key => $val) {
            $values[] = $this->factory->createValue($field, $key, $val);
        }

        return $this->factory->createValueCollection($field, $values);
    }
}
