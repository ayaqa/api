<?php

namespace AyaQA\Support\Bug\Manifest;

use AyaQA\Support\Bug\Manifest\Contract\Bug;
use AyaQA\Support\Bug\Manifest\Contract\BugCondition;
use AyaQA\Support\Bug\Manifest\Contract\BugTarget;
use AyaQA\Support\Bug\Manifest\Contract\HasDescription;
use AyaQA\Support\Bug\Manifest\Target\AnyTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxOneTarget;
use AyaQA\Support\Bug\Manifest\Target\CheckboxTwoTarget;

class ManifestManager
{
    protected bool $booted = false;

    /** @var BugTarget[] */
    protected array $targets = [];

    /** @var Bug[] */
    protected array $bugs = [];

    /** @var BugCondition[] */
    protected array $conditions = [];

    private const AVAILABLE_TARGETS = [
        AnyTarget::class,
        CheckboxOneTarget::class,
        CheckboxTwoTarget::class,
    ];

    public function __construct(private ManifestFactory $factory)
    {
    }

    public function boot()
    {
        foreach (self::AVAILABLE_TARGETS as $target) {
            $target = $this->addTarget($target);

            foreach ($target->getSupportedBugs() as $bug) {
                $bug = $this->addBug($bug);

                foreach ($bug->getSupportedConditions() as $condition) {
                    $this->addCondition($condition);
                }
            }
        }

        $this->booted = true;
    }

    public function presentTargets(): array
    {
        $targets = [];
        foreach ($this->targets as $target) {

            $bugs = [];
            foreach ($target->getSupportedBugs() as $bug) {
                $bugs[] = $this->getBug($bug)->getId();
            }

            $targets[] = [
                'id' => $target->getId(),
                'text' => $target->getText(),
                'attributes' => [
                    'ui' => $target->getUIElements(),
                    'reqParams' => $target->getRequestParams(),
                    'respParams' => $target->getResponseParams(),
                ],
                'bugs'  => $bugs
            ];
        }

        return $targets;
    }

    public function presentBugs(): array
    {
        $bugs = [];
        foreach ($this->bugs as $bug) {
            $conditions = [];
            foreach ($bug->getSupportedConditions() as $condition) {
                $conditions[] = $this->getCondition($condition)->getId();
            }

            $tmpBug = [
                'id' => $bug->getId(),
                'text' => $bug->getText(),
                'for' => $bug->applicableTo()->get(),
                'configType' => $bug->getConfigType()->get(),
                'conditions' => $conditions
            ];

            if ($bug instanceof HasDescription) {
                $tmpBug['description'] = $bug->getDescription();
            }

            $bugs[] = $tmpBug;
        }

        return $bugs;
    }

    public function presentConditions(): array
    {
        $conditions = [];
        foreach ($this->conditions as $condition) {
            $tmpCondition = [
                'id' => $condition->getId(),
                'text' => $condition->getText(),
                'configType' => $condition->getConfigType()->get(),
            ];

            if ($condition instanceof HasDescription) {
                $tmpCondition['description'] = $condition->getDescription();
            }

            $conditions[] = $tmpCondition;
        }

        return $conditions;
    }

    public function getBug(string $bugClass): Bug
    {
        if (false === array_key_exists($bugClass, $this->bugs)) {
            // @TODO throw exception
        }

        return $this->bugs[$bugClass];
    }

    public function getCondition(string $conditionClass): BugCondition
    {
        if (false === array_key_exists($conditionClass, $this->conditions)) {
            // @TODO throw exception
        }

        return $this->conditions[$conditionClass];
    }

    protected function addTarget(string $targetClass): BugTarget
    {
        $target = $this->factory->createTarget($targetClass);
        if (array_key_exists($targetClass, $this->targets)) {
            // @TODO exception
        }

        $this->targets[$targetClass] = $target;

        return $target;
    }

    protected function addBug(string $bugClass): Bug
    {
        $bug = $this->factory->createBug($bugClass);
        if (array_key_exists($bugClass, $this->bugs)) {
            return $this->bugs[$bugClass];
        }

        $this->bugs[$bugClass] = $bug;

        return $bug;
    }

    protected function addCondition(string $conditionClass): BugCondition
    {
        $condition = $this->factory->createCondition($conditionClass);
        if (array_key_exists($conditionClass, $this->conditions)) {
            return $this->conditions[$conditionClass];
        }

        $this->conditions[$conditionClass] = $condition;

        return $condition;
    }
}
