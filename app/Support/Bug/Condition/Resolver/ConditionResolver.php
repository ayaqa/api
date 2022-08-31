<?php

namespace AyaQA\Support\Bug\Condition\Resolver;

use AyaQA\Support\Bug\Bug;
use AyaQA\Support\Bug\BugMapper;
use AyaQA\Support\Bug\Condition\ConditionType;
use AyaQA\Support\Bug\Context\BugContext;
use AyaQA\Support\Bug\Manifest\ManifestFactory;
use AyaQA\Support\Bug\Value\BugValueType;

class ConditionResolver
{
    public function __construct(
        private BugContext $bugContext,
        private ManifestFactory $manifestFactory
    ){}

    public function matching(Bug $bug): bool
    {
        return $this->matchingTarget($bug) && $this->meetsCondition($bug);
    }

    public function matchingTarget(Bug $bug): bool
    {
        if ($bug->target->value() === BugMapper::ANY_TARGET) {
            return true;
        }

        if ($this->bugContext->hasValue(BugValueType::SECTION_ID)) {
            $contextValue = $this->bugContext->get(BugValueType::SECTION_ID);

            return $bug->target->sameAs($contextValue);
        }

        return false;
    }

    public function meetsCondition(Bug $bug): bool
    {
        $conditionType = ConditionType::from($bug->condition->getId());

        if ($conditionType === ConditionType::ALWAYS) {
            return true;
        }

        $isSatisfied = false;
        $manifestCondition = $this->manifestFactory->createCondition(
            BugMapper::getConditionClass($bug->condition->getId())
        );

        foreach ($manifestCondition->evaluateAgainst() as $dataType) {
            if (false === $this->bugContext->has($dataType)) {
                continue;
            }

            $isSatisfied = $bug->condition->isSatisfied(
                $this->bugContext->get($dataType)
            );

            // in case matching - just return it
            if ($isSatisfied) {
                break;
            }
        }

        return $isSatisfied;
    }
}
