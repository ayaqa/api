<?php

namespace AyaQA\Support\Bug\Context;

use AyaQA\Support\Bug\Context\Exception\ContextException;
use AyaQA\Support\Bug\Context\Exception\OverrideContextValueException;
use AyaQA\Support\Bug\Value\BugValueType;
use AyaQA\Support\Bug\Value\Contract\BugKeyValue;
use AyaQA\Support\Bug\Value\Contract\BugValue;
use AyaQA\Support\Bug\Value\Contract\BugValueCollection;

class BugContext
{
    /**
     * @var BugValue|BugKeyValue[]
     */
    private array $values = [];

    /**
     * @var BugValueCollection[]
     */
    private array $collections = [];

    public function has(BugValueType $field): bool
    {
        return $this->hasCollection($field) || $this->hasValue($field);
    }

    public function set(BugValueType $field, BugValue|BugValueCollection $value, $overrideIfSet = false): self
    {
        if ($value instanceof BugValueCollection) {
            return $this->setCollection($field, $value, $overrideIfSet);
        }

        return $this->setValue($field, $value, $overrideIfSet);
    }

    public function get(BugValueType $field): BugValue|BugValueCollection|null
    {
        if ($this->hasCollection($field)) {
            return $this->getCollection($field);
        }

        if ($this->hasValue($field)) {
            return $this->getValue($field);
        }

        throw ContextException::notFound($field);
    }

    public function hasValue(BugValueType $field): bool
    {
        return isset($this->values[$field->asString()]);
    }

    public function hasCollection(BugValueType $field): bool
    {
        return isset($this->collections[$field->asString()]);
    }

    /**
     * @param BugValueType $field
     *
     * @return BugValue|null
     */
    private function getValue(BugValueType $field): ?BugValue
    {
        if (false === $this->hasValue($field)) {
            return null;
        }

        return $this->values[$field->asString()];
    }

    /**
     * @param BugValueType $field
     *
     * @return BugValueCollection|null
     */
    private function getCollection(BugValueType $field): ?BugValueCollection
    {
        if (false === $this->hasCollection($field)) {
            return null;
        }

        return $this->collections[$field->asString()];
    }

    private function setValue(BugValueType $field, BugValue $value, $overrideIfSet = false): self
    {
        if ($this->hasValue($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideValue($field);
        }

        if ($field->hasCollection()) {
            throw ContextException::shouldBeCollection($field);
        }

        $this->values[$field->asString()] = $value;

        return $this;
    }

    private function setCollection(BugValueType $field, BugValueCollection $collection, $overrideIfSet = false): self
    {
        if ($this->hasCollection($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideCollection($field);
        }

        if (false === $field->hasCollection()) {
            throw ContextException::shouldBeValue($field);
        }

        $this->collections[$field->asString()] = $collection;

        return $this;
    }
}
