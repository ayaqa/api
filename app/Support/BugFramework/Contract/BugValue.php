<?php

namespace AyaQA\Support\BugFramework\Contract;

interface BugValue
{
    public function value(): mixed;

    /**
     * Check if passed value object has same type and value
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameAs(BugValue $value): bool;

    /**
     * Check if passed value object is same type
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameTypeAs(BugValue $value): bool;

    /**
     * Check if passed value object has same value
     *
     * @param BugValue $value
     *
     * @return bool
     */
    public function sameValueAs(BugValue $value): bool;
}
