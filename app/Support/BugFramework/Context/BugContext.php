<?php

namespace AyaQA\Support\BugFramework\Context;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Contract\BugValue;
use AyaQA\Support\BugFramework\Value\Collection\Collection;

class BugContext
{
    private array $values = [];
    private array $collections = [];

    public function setValue(BugTarget $type, BugValue $bugValue, bool $overrideIfExists = false): self
    {
        // @TODO check if exists and throw exception if no override
        $this->values[$type->name] = $bugValue;

        return $this;
    }

    public function setCollection(BugTarget $type, Collection $collection, bool $overrideIfExists = false): self
    {
        // @TODO check if exists and throw exception if no override
        $this->collections[$type->name] = $collection;

        return $this;
    }

    /**
     * @param BugTarget $type
     *
     * @return BugValue|null
     */
    public function getValue(BugTarget $type): ?BugValue
    {
        return $this->values[$type->name] ?? null;
    }

    /**
     * @param BugTarget $type
     *
     * @return bool
     */
    public function hasValue(BugTarget $type): bool
    {
        return isset($this->values[$type->name]);
    }

    /**
     * @param BugTarget $type
     *
     * @return Collection|null
     */
    public function getCollection(BugTarget $type): ?Collection
    {
        return $this->collections[$type->name] ?? null;
    }

    /**
     * @param BugTarget $type
     *
     * @return bool
     */
    public function hasCollection(BugTarget $type): bool
    {
        return isset($this->collections[$type->name]);
    }
}
