<?php

namespace AyaQA\Support\BugFramework\Bug;

use AyaQA\Enum\SectionId;
use AyaQA\Support\BugFramework\Bug\Action\ActionGroup;
use AyaQA\Support\BugFramework\Condition\Condition;
use AyaQA\Support\BugFramework\Condition\ConditionFactory;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\ConfiguredBug;
use AyaQA\Support\BugFramework\ConfiguredBugs;
use AyaQA\Support\BugFramework\Manifest\ManifestFactory;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use AyaQA\Support\BugFramework\Support\Config;
use AyaQA\Support\BugFramework\Support\ConfigType;
use AyaQA\Support\BugFramework\Value\Factory\ValueFactory;
use AyaQA\Support\BugFramework\Value\ValueType;

class BugFactory
{
    public function __construct(
        private ValueFactory $valueFactory,
        private ConditionFactory $conditionFactory,
        private ManifestFactory $manifestFactory,
    ){}

    public function createConfiguredBug(array $payload): ConfiguredBug
    {
        if (false === $payload['applicable'] instanceof ApplicableTo) {
            $payload['applicable'] = ApplicableTo::from($payload['applicable']);
        }

        if (false === $payload['target'] instanceof SectionId) {
            $payload['target'] = $this->valueFactory->createValue(ValueType::SECTION_ID, $payload['target']);
        }

        if (false === $payload['condition'] instanceof Condition) {
            $conditionType = ConditionType::from($payload['condition']);
            $conditionManifest = $this->manifestFactory->createCondition($conditionType->getManifestClass());

            $payload['condition'] = $this->conditionFactory->create(
                $payload['condition'],
                $payload['conditionConfig'],
                $conditionManifest->getConfigType(),
                $conditionManifest->shouldEvalAtStep(),
            );
        }

        if (false === $payload['bug'] instanceof Bug) {
            $payload['bug'] = $this->createBug($payload['bug'], $payload['bugConfig']);
        }

        return new ConfiguredBug(
            $payload['target'],
            $payload['applicable'],
            $payload['bug'],
            $payload['condition']
        );
    }

    public function createConfiguredBugs(array $bugs = []): ConfiguredBugs
    {
        $bugsValueObject = new ConfiguredBugs();
        foreach ($bugs as $bug) {
            $bugsValueObject->append(
                $this->createConfiguredBug($bug)
            );
        }

        return $bugsValueObject;
    }

    public function createBug(string $id, array $config): Bug
    {
        $bugType = BugType::from($id);
        $bugManifest = $this->manifestFactory->createBug($bugType->getManifestClass());

        return new Bug(
            $id,
            $this->createConfig($config, $bugManifest->getConfigType()),
            $this->createActionGroup($bugType->getActions()),
        );
    }

    public function createConfig(array $config, ConfigType $configType): Config
    {
        return new Config($config, $configType);
    }

    public function createActionGroup(array $actions): ActionGroup
    {
        return ActionGroup::from(...$actions);
    }
}
