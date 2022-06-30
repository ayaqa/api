<?php

namespace AyaQA\Support\Bug\Condition\Enum;

use AyaQA\Support\Bug\Field\Base\KeyValueFieldValue;
use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Field\Contract\BugFieldValue;

enum BugTarget
{
    case PARAM_KEY;
    case PARAM_VALUE;
    case HEADER_KEY;
    case HEADER_VALUE;
    case PAGE_ID;

    public function operators(): array
    {
        return [
            BugOperator::IS,
            BugOperator::IS_NOT,
            BugOperator::IS_EMPTY,
            BugOperator::IS_NOT_EMPTY,
            BugOperator::CONTAINS,
            BugOperator::DOES_NOT_CONTAINS,
        ];
    }

    /**
     * @return BugField
     */
    public function getBugField(): BugField
    {
        return match ($this) {
            self::PARAM_KEY, self::PARAM_VALUE => BugField::PARAMETER,
            self::HEADER_KEY, self::HEADER_VALUE => BugField::HEADER,
            self::PAGE_ID => BugField::PAGE_ID
        };
    }

    public function getFieldValue(BugFieldValue $value): string|int|null
    {
        if ($value instanceof KeyValueFieldValue
            && in_array($this, [self::HEADER_KEY, self::PARAM_KEY])
        ) {
            return $value->key();
        }

        return $value->value();
    }
}
