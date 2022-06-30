<?php

namespace AyaQA\Support\Bug\Context;

use AyaQA\Support\Bug\Context\Exception\ContextException;
use AyaQA\Support\Bug\Context\Exception\OverrideContextValueException;
use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Field\Contract\BugFieldCollection;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

class BugContext
{
    /**
     * @var BugFieldValue[]
     */
    private array $values = [];

    /**
     * @var BugFieldCollection[]
     */
    private array $collections = [];

    public function has(BugField $field): bool
    {
        return $this->hasCollection($field) || $this->hasValue($field);
    }

    public function set(BugField $field, BugFieldValue|BugFieldCollection $value, $overrideIfSet = false): self
    {
        if ($value instanceof BugFieldCollection) {
            return $this->setCollection($field, $value, $overrideIfSet);
        }

        return $this->setValue($field, $value, $overrideIfSet);
    }

    public function get(BugField $field): BugFieldValue|BugFieldCollection|null
    {
        if ($this->hasCollection($field)) {
            return $this->getCollection($field);
        }

        if ($this->hasValue($field)) {
            return $this->getValue($field);
        }

        throw ContextException::noValueSet($field);
    }

    private function hasValue(BugField $field): bool
    {
        return isset($this->values[$field->asString()]);
    }

    private function hasCollection(BugField $field): bool
    {
        return isset($this->collections[$field->asString()]);
    }

    /**
     * @param BugField $field
     *
     * @return BugFieldValue|null
     */
    private function getValue(BugField $field): ?BugFieldValue
    {
        if (false === $this->hasValue($field)) {
            return null;
        }

        return $this->values[$field->asString()];
    }

    /**
     * @param BugField $field
     *
     * @return BugFieldCollection|null
     */
    private function getCollection(BugField $field): ?BugFieldCollection
    {
        if (false === $this->hasCollection($field)) {
            return null;
        }

        return $this->collections[$field->asString()];
    }

    private function setValue(BugField $field, BugFieldValue $value, $overrideIfSet = false): self
    {
        if ($this->hasValue($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideValue($field);
        }

        if ($field->shouldBeCollection()) {
            throw ContextException::shouldBeCollection($field);
        }

        $this->values[$field->asString()] = $value;

        return $this;
    }

    private function setCollection(BugField $field, BugFieldCollection $collection, $overrideIfSet = false): self
    {
        if ($this->hasCollection($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideCollection($field);
        }

        if (false === $field->shouldBeCollection()) {
            throw ContextException::shouldBeValue($field);
        }

        $this->collections[$field->asString()] = $collection;

        return $this;
    }
}
