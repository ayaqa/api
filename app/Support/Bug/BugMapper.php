<?php

namespace AyaQA\Support\Bug;

use AyaQA\Enum\SectionId;
use AyaQA\Support\Bug\Manifest\Bug\HideUIElementBug;
use AyaQA\Support\Bug\Manifest\Bug\ModifyRequestParameter;
use AyaQA\Support\Bug\Manifest\Condition\AlwaysCondition;
use AyaQA\Support\Bug\Manifest\Condition\IfToggleableIsCondition;
use AyaQA\Support\Bug\Manifest\Target\AnyTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxOneTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxTwoTarget;

class BugMapper
{
    protected static bool $isBooted = false;

    protected static array $targets = [];
    protected static array $bugs = [];
    protected static array $conditions = [];

    public static function getTargetId(string $targetClass): string
    {
        return static::findKeyByValue($targetClass, static::$targets);
    }

    public static function getBugId(string $bugClass): string
    {
        return static::findKeyByValue($bugClass, static::$bugs);
    }

    public static function getConditionId(string $conditionClass): string
    {
        return static::findKeyByValue($conditionClass, static::$conditions);
    }

    protected static function boot(): void
    {
        if (static::$isBooted) {
            return;
        }

        static::$targets = [
            'any'                         => AnyTarget::class,
            SectionId::CHECKBOX_01->get() => CheckboxOneTarget::class,
            SectionId::CHECKBOX_02->get() => CheckboxTwoTarget::class
        ];

        static::$bugs = [
            'hide-ui-el'        => HideUIElementBug::class,
            'modify-req-param'  => ModifyRequestParameter::class
        ];

        static::$conditions = [
            'always'           => AlwaysCondition::class,
            'if-toggleable-is' => IfToggleableIsCondition::class,
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
}
