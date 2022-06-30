<?php

namespace AyaQA\Support\Bug\Field\Base;

use AyaQA\Support\Bug\Field\Contract\BugFieldCollection;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;
use AyaQA\Support\Bug\Support\Validation\AssertHelper;

abstract class BaseFieldCollection implements BugFieldCollection
{
    /** @var BugFieldValue[] */
    private array $fields;

    final public function __construct(array $fields)
    {
        AssertHelper::isCollectionOfType($fields, static::isCollectionOf());

        $this->fields = $fields;
    }

    public function toArray(): array
    {
        return $this->fields;
    }

    public function contains(BugFieldValue $value): bool
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
