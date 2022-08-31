<?php

namespace AyaQA\Support\Bug;

use AyaQA\Enum\SectionId;
use AyaQA\Support\Bug\Condition\Condition;
use AyaQA\Support\Bug\Condition\ConditionFactory;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\ManifestFactory;
use AyaQA\Support\Bug\Value\BugValueType;
use AyaQA\Support\Bug\Value\Factory\ValueFactory;

class BugFactory
{
    public function __construct(
        private ValueFactory $valueFactory,
        private ConditionFactory $conditionFactory,
        private ManifestFactory $manifestFactory,
    ){}

    public function createBug(array $payload): Bug
    {
        if (false === $payload['applicable'] instanceof ApplicableTo) {
            $payload['applicable'] = ApplicableTo::from($payload['applicable']);
        }

        if (false === $payload['target'] instanceof SectionId) {
            $payload['target'] = $this->valueFactory->createValue(BugValueType::SECTION_ID, $payload['target']);
        }

        if (false === $payload['condition'] instanceof Condition) {
            $conditionManifest = $this->manifestFactory->createCondition(BugMapper::getConditionClass($payload['condition']));
            $payload['condition'] = $this->conditionFactory->create(
                $payload['condition'],
                $payload['conditionConfig'],
                $conditionManifest->getConfigType()
            );
        }

        return new Bug(
            $payload['target'],
            $payload['applicable'],
            $payload['bug'],
            $payload['bugConfig'],
            $payload['condition']
        );
    }

    public function createBugs(array $bugs = []): Bugs
    {
        $bugsValueObject = new Bugs();
        foreach ($bugs as $bug) {
            $bugsValueObject->add(
                $this->createBug($bug)
            );
        }

        return $bugsValueObject;
    }
}
