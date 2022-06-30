<?php

namespace AyaQA\Support\BugFramework\Value\Contract;

interface BugValue
{
    public function value(): mixed;

    /**
     * Check if passed value object has same type and value
     *
     * @param BugField $value
     *
     * @return bool
     */
    public function sameAs(BugField $value): bool;

    /**
     * Check if passed value object is same type
     *
     * @param BugField $value
     *
     * @return bool
     */
    public function sameTypeAs(BugField $value): bool;

    /**
     * Check if passed value object has same value
     *
     * @param BugField $value
     *
     * @return bool
     */
    public function sameValueAs(BugField $value): bool;
}
