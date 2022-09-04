<?php

namespace AyaQA\Support\BugFramework\Context;

use AyaQA\Support\BugFramework\Context\Exception\ContextException;
use AyaQA\Support\BugFramework\Context\Exception\OverrideContextValueException;
use AyaQA\Support\BugFramework\Value\ValueType;
use AyaQA\Support\BugFramework\Value\Contract\BugKeyValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Contract\BugValueCollection;

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

    public function has(ValueType $field): bool
    {
        return $this->hasCollection($field) || $this->hasValue($field);
    }

    public function set(ValueType $field, BugValue|BugValueCollection $value, $overrideIfSet = false): self
    {
        if ($value instanceof BugValueCollection) {
            return $this->setCollection($field, $value, $overrideIfSet);
        }

        return $this->setValue($field, $value, $overrideIfSet);
    }

    public function get(ValueType $field): BugValue|BugValueCollection|null
    {
        if ($this->hasCollection($field)) {
            return $this->getCollection($field);
        }

        if ($this->hasValue($field)) {
            return $this->getValue($field);
        }

        throw ContextException::notFound($field);
    }

    public function hasValue(ValueType $field): bool
    {
        return isset($this->values[$field->getId()]);
    }

    public function hasCollection(ValueType $field): bool
    {
        return isset($this->collections[$field->getId()]);
    }

    /**
     * @param ValueType $field
     *
     * @return BugValue|null
     */
    private function getValue(ValueType $field): ?BugValue
    {
        if (false === $this->hasValue($field)) {
            return null;
        }

        return $this->values[$field->getId()];
    }

    /**
     * @param ValueType $field
     *
     * @return BugValueCollection|null
     */
    private function getCollection(ValueType $field): ?BugValueCollection
    {
        if (false === $this->hasCollection($field)) {
            return null;
        }

        return $this->collections[$field->getId()];
    }

    private function setValue(ValueType $field, BugValue $value, $overrideIfSet = false): self
    {
        if ($this->hasValue($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideValue($field);
        }

        if ($field->hasCollection()) {
            throw ContextException::shouldBeCollection($field);
        }

        $this->values[$field->getId()] = $value;

        return $this;
    }

    private function setCollection(ValueType $field, BugValueCollection $collection, $overrideIfSet = false): self
    {
        if ($this->hasCollection($field) && false === $overrideIfSet) {
            throw OverrideContextValueException::noOverrideCollection($field);
        }

        if (false === $field->hasCollection()) {
            throw ContextException::shouldBeValue($field);
        }

        $this->collections[$field->getId()] = $collection;

        return $this;
    }
}
