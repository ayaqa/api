<?php

namespace AyaQA\Support\Bug\Field;

use AyaQA\Support\Bug\Field\Collection\BugHeaderFields;
use AyaQA\Support\Bug\Field\Collection\BugParamFields;
use AyaQA\Support\Bug\Support\Concern\StringableEnum;
use Throwable;

enum BugField: string
{
    use StringableEnum;

    case HEADER = 'REQ_HEADER';
    case PARAMETER = 'REQ_PARAM';
    case PAGE_ID = 'PAGE_ID';

    /**
     * @return class-string
     */
    public function getFieldClass(): string
    {
        return match ($this) {
            self::HEADER => BugHeaderField::class,
            self::PARAMETER => BugParamField::class,
            self::PAGE_ID => BugPageIdField::class,
            default => throw new \RuntimeException(
                sprintf('Field value %s dont have mapped value object.', $this->name)
            )
        };
    }

    /**
     * @return class-string
     */
    public function getCollectionClass(): string
    {
        return match ($this) {
            self::HEADER => BugHeaderFields::class,
            self::PARAMETER => BugParamFields::class,
            default => throw new \RuntimeException(
                sprintf('Field value %s dont have collection or is not mapped yet.', $this->name)
            )
        };
    }

    public function shouldBeCollection(): bool
    {
        try {
            self::getCollectionClass();
            return true;
        } catch (Throwable) {
        }

        return false;
    }
}
