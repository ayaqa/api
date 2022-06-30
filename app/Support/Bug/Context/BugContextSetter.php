<?php

namespace AyaQA\Support\Bug\Context;

use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Field\Contract\BugFieldCollection;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;
use AyaQA\Support\Bug\Field\Factory\FieldFactory;

class BugContextSetter
{
    public function __construct(
        private FieldFactory $factory,
        private BugContext $context,
    ){}

    public function set(BugField $field, array $data): self
    {
        if (false === $field->shouldBeCollection()) {
            $value = $this->createValue($field, ...$data);
        } else {
            $value = $this->createCollection($field, $data);
        }

        $this->context->set($field, $value, false);

        return $this;
    }

    private function createValue(BugField $field, mixed ...$args): BugFieldValue
    {
        // @TODO input data validation
        return $this->factory->createField($field, $args);
    }

    private function createCollection(BugField $field, array $data): BugFieldCollection
    {
        // @TODO input data validation
        $values = [];
        foreach ($data as $key => $val) {
            $values[] = $this->factory->createField($field, $key, $val);
        }

        return $this->factory->createFieldCollection($field, $values);
    }
}
