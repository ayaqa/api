<?php

namespace AyaQA\Support\Bug\Condition;

use AyaQA\Support\Bug\Condition\Operator\ValueIsEqualOperator;
use AyaQA\Support\Bug\Condition\Operator\ValueKeyExistsOperator;
use AyaQA\Support\Bug\Support\Exception\BugException;

enum ConditionType: string
{
    case ALWAYS = 'always';
    case IF_REQ_PARAM_IS = 'if-req-param-is';
    case IF_REQ_PARAM_KEY_EXISTS = 'if-req-param-key-exists';
    case IF_RESP_PARAM_IS = 'if-resp-param-is';

    public function get(): string
    {
        return $this->value;
    }

    /**
     * @return class-string[]
     */
    public function getOperators(): array
    {
        return match ($this) {
            self::IF_REQ_PARAM_IS => [
                ValueIsEqualOperator::class
            ],
            self::IF_REQ_PARAM_KEY_EXISTS => [
                ValueKeyExistsOperator::class
            ],
            self::IF_RESP_PARAM_IS => [
                ValueKeyExistsOperator::class,
                ValueIsEqualOperator::class
            ],
            default => throw new BugException(
                sprintf('There are no operators for %s condition type', $this->get())
            )
        };
    }
}
