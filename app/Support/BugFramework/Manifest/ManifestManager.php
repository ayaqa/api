<?php

namespace AyaQA\Support\BugFramework\Manifest;

use AyaQA\Support\BugFramework\Manifest\Contract\Bug;
use AyaQA\Support\BugFramework\Manifest\Contract\BugCondition;
use AyaQA\Support\BugFramework\Manifest\Contract\BugTarget;
use AyaQA\Support\BugFramework\Manifest\Contract\HasDescription;
use AyaQA\Support\BugFramework\Manifest\Target\AnyTarget;
use AyaQA\Support\BugFramework\Manifest\Target\CheckboxOneTarget;
use AyaQA\Support\BugFramework\Manifest\Target\CheckboxTwoTarget;

class ManifestManager
{
    protected bool $booted = false;

    /** @var BugTarget[] */
    protected array $targets = [];

    /** @var Bug[] */
    protected array $bugs = [];

    /** @var BugCondition[] */
    protected array $conditions = [];

    public function __construct(
        private ManifestFactory $factory,
        private array $availableTargets = []
    ){
        $this->availableTargets = [
            AnyTarget::class,
            CheckboxOneTarget::class,
            CheckboxTwoTarget::class,
        ];
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->availableTargets as $target) {
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
                'for' => $bug->applicableTo()->getId(),
                'configType' => $bug->getConfigType()->getId(),
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
                'configType' => $condition->getConfigType()->getId(),
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
