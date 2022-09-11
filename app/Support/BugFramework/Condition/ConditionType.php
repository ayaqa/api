<?php

namespace AyaQA\Support\BugFramework\Condition;

use AyaQA\Support\BugFramework\Condition\Operator\Type\ValueIsEqualOperator;
use AyaQA\Support\BugFramework\Condition\Operator\Type\ValueKeyExistsOperator;
use AyaQA\Support\BugFramework\Manifest\Condition\AlwaysManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamIsManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfReqParamKeyExistsManifestCondition;
use AyaQA\Support\BugFramework\Manifest\Condition\IfRespParamIsManifestCondition;
use AyaQA\Support\BugFramework\Support\Contract\HasId;
use AyaQA\Support\BugFramework\Support\Exception\BugException;

enum ConditionType: string implements HasId
{
    case ALWAYS = 'always';
    case IF_REQ_PARAM_IS = 'if-req-param-is';
    case IF_REQ_PARAM_KEY_EXISTS = 'if-req-param-key-exists';
    case IF_RESP_PARAM_IS = 'if-resp-param-is';

    public function getId(): string
    {
        return $this->value;
    }

    /**
     * @return class-string
     */
    public function getManifestClass(): string
    {
        return match($this) {
            ConditionType::ALWAYS                  => AlwaysManifestCondition::class,
            ConditionType::IF_REQ_PARAM_IS         => IfReqParamIsManifestCondition::class,
            ConditionType::IF_REQ_PARAM_KEY_EXISTS => IfReqParamKeyExistsManifestCondition::class,
            ConditionType::IF_RESP_PARAM_IS        => IfRespParamIsManifestCondition::class,
            default => throw new BugException(
                sprintf('There is no manifest class mapped to %s', $this->getId())
            )
        };
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
                sprintf('There are no operators for %s condition type', $this->getId())
            )
        };
    }
}
