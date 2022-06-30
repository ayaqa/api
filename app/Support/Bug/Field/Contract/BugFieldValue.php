<?php

namespace AyaQA\Support\Bug\Field\Contract;

interface BugFieldValue
{
    public function value(): mixed;

    /**
     * Compare if is same as other bug field
     *
     * @param BugFieldValue $value
     *
     * @return bool
     */
    public function sameAs(BugFieldValue $value): bool;

    /**
     * Compare field only by their types
     *
     * @param BugFieldValue $value
     *
     * @return bool
     */
    public function sameTypeAs(BugFieldValue $value): bool;

    /**
     * Compare only values of fields without checking type
     *
     * @param BugFieldValue $value
     *
     * @return bool
     */
    public function sameValueAs(BugFieldValue $value): bool;
}
