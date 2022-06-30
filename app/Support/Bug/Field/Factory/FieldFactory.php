<?php

namespace AyaQA\Support\Bug\Field\Factory;

use AyaQA\Support\Bug\Field\BugField;

class FieldFactory
{
    public function create(string $field, mixed ...$args)
    {
        $field = BugField::from($field);

        return $this->createField($field, ...$args);
    }

    public function createField(BugField $field, mixed ...$args)
    {
        $fieldClass = $field->getFieldClass();

        return new $fieldClass(...$args);
    }

    public function createFieldCollection(BugField $field, array $data)
    {
        $collectionClass = $field->getCollectionClass();

        return new $collectionClass($data);
    }
}
