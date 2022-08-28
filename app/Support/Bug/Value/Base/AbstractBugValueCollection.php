<?php

namespace AyaQA\Support\Bug\Value\Base;

use AyaQA\Support\Bug\Support\Validation\AssertHelper;
use AyaQA\Support\Bug\Value\Contract\BugValue;
use AyaQA\Support\Bug\Value\Contract\BugValueCollection;

abstract class AbstractBugValueCollection implements BugValueCollection
{
    /** @var BugValue[] */
    private array $fields;

    final public function __construct(array $fields)
    {
        AssertHelper::isCollectionOfType($fields, static::isCollectionOf());

        $this->fields = $fields;
    }

    public function values(): array
    {
        return $this->fields;
    }

    public function contains(BugValue $value): bool
    {
        $isFound = false;
        foreach ($this->fields as $field) {
            $isFound = $field->sameAs($value);

            if ($isFound) {
                break;
            }
        }

        return $isFound;
    }
}
