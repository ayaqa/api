<?php

namespace AyaQA\Support\Bug\Value\Contract;

interface BugValue
{
    public function value(): mixed;

    /**
     * Compare if is same as other bug field
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameAs(BugValue $value): bool;

    /**
     * Compare field only by their types
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameTypeAs(BugValue $value): bool;

    /**
     * Compare only values of fields without checking type
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameValueAs(BugValue $value): bool;
}
