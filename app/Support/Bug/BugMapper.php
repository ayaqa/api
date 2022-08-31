<?php

namespace AyaQA\Support\Bug;

use AyaQA\Enum\SectionId;
use AyaQA\Support\Bug\Condition\ConditionType;
use AyaQA\Support\Bug\Manifest\Bug\API\ModifyRequestParameter;
use AyaQA\Support\Bug\Manifest\Bug\API\ModifyResponseParameter;
use AyaQA\Support\Bug\Manifest\Bug\UI\HideUIElementBug;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamIsCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfReqParamKeyExistsCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfRespParamIsCondition;
use AyaQA\Support\Bug\Manifest\Target\AnyTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxOneTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxTwoTarget;

class BugMapper
{
    public const ANY_TARGET = 'any';

    protected static bool $isBooted = false;

    protected static array $targets = [];
    protected static array $bugs = [];
    protected static array $conditions = [];

    /**
     * @param class-string $targetClass
     *
     * @return string
     */
    public static function getTargetId(string $targetClass): string
    {
        return static::findKeyByValue($targetClass, static::$targets);
    }

    /**
     * @param class-string $bugClass
     *
     * @return string
     */
    public static function getBugId(string $bugClass): string
    {
        return static::findKeyByValue($bugClass, static::$bugs);
    }

    /**
     * @param class-string $conditionClass
     *
     * @return string
     */
    public static function getConditionId(string $conditionClass): string
    {
        return static::findKeyByValue($conditionClass, static::$conditions);
    }

    /**
     * @param string $id
     *
     * @return class-string
     */
    public static function getConditionClass(string $id): string
    {
        return static::findClassById($id, static::$conditions);
    }

    protected static function boot(): void
    {
        if (static::$isBooted) {
            return;
        }

        static::$targets = [
            self::ANY_TARGET              => AnyTarget::class,
            SectionId::CHECKBOX_01->get() => CheckboxOneTarget::class,
            SectionId::CHECKBOX_02->get() => CheckboxTwoTarget::class
        ];

        static::$bugs = [
            'hide-ui-el'        => HideUIElementBug::class,
            'modify-req-param'  => ModifyRequestParameter::class,
            'modify-resp-param' => ModifyResponseParameter::class,
        ];

        static::$conditions = [
            ConditionType::ALWAYS->get()                  => AlwaysCondition::class,
            ConditionType::IF_REQ_PARAM_IS->get()         => IfReqParamIsCondition::class,
            ConditionType::IF_REQ_PARAM_KEY_EXISTS->get() => IfReqParamKeyExistsCondition::class,
            ConditionType::IF_RESP_PARAM_IS->get()        => IfRespParamIsCondition::class,
        ];

        static::$isBooted = true;
    }

    protected static function findKeyByValue($class, array &$data): string
    {
        static::boot();

        $id = array_search($class, $data);

        if (false === $id) {
            // @TODO change exception
            throw new \RuntimeException('cannot find mapping for: ' . $class);
        }

        return $id;
    }

    protected static function findClassById($id, array &$data): string
    {
        static::boot();

        if (false === array_key_exists($id, $data)) {
            // @TODO change exception
            throw new \RuntimeException('cannot find mapping for: ' . $id);
        }

        return $data[$id];
    }
}
