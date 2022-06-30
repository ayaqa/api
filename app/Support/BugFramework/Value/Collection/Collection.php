<?php

namespace AyaQA\Support\BugFramework\Value\Collection;

use AyaQA\Support\BugFramework\Support\Validation\AssertHelper;
use AyaQA\Support\BugFramework\Support\Validation\Exception\AssertionFailed;
use AyaQA\Support\BugFramework\Value\Concern\ComparableValue;
use AyaQA\Support\BugFramework\Value\Contract\BugField;
use AyaQA\Support\BugFramework\Value\Contract\BugFieldCollection;

class Collection implements BugFieldCollection
{
    use ComparableValue {
        sameValueAs as compareValue;
        sameTypeAs as  compareType;
    }

    private string $type;

    /** @var BugField[] */
    private array $items = [];

    public function __construct(string $valueClass, array $items = [])
    {
        AssertHelper::isClass($valueClass);
        AssertHelper::isCollectionOfType($items, $valueClass);

        $this->type = $valueClass;
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getValueType(): string
    {
        return $this->type;
    }

    /**
     * @return BugField[]
     */
    public function value(): array
    {
        return $this->items;
    }

    public function sameTypeAs(BugField $value): bool
    {
        try {
            AssertHelper::isInstanceOf($value, BugFieldCollection::class);
        } catch (AssertionFailed) {
            return false;
        }

        return $this->getValueType() === $value->getValueType();
    }

    public function sameValueAs(BugField $value): bool
    {
        if (false === $this->sameTypeAs($value)) {
            return false;
        }

        // @TODO test and optimise
        $uDiff = array_diff($this->items, $value->value());

        return empty($uDiff);
    }
}
