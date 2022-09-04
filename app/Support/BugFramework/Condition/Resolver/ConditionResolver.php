<?php

namespace AyaQA\Support\BugFramework\Condition\Resolver;

use AyaQA\Support\BugFramework\ConfiguredBug;
use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Manifest\ManifestFactory;
use AyaQA\Support\BugFramework\Manifest\Target\AnyTarget;
use AyaQA\Support\BugFramework\Value\Custom\AppFlowStepValue;
use AyaQA\Support\BugFramework\Value\ValueType;

class ConditionResolver
{
    public function __construct(
        private BugContext $bugContext,
        private ManifestFactory $manifestFactory
    ){}

    public function hasSameTarget(ConfiguredBug $bug): bool
    {
        // if is any - skip comparison
        if ($bug->target->value() === AnyTarget::ANY_TARGET) {
            return true;
        }

        // target can be only sections for now
        if ($this->bugContext->hasValue(ValueType::SECTION_ID)) {
            $contextValue = $this->bugContext->get(ValueType::SECTION_ID);

            return $bug->target->sameAs($contextValue);
        }

        return false;
    }

    public function evalCondition(ConfiguredBug $bug): void
    {
        $conditionType = ConditionType::from($bug->condition->getId());

        $manifestCondition = $this->manifestFactory->createCondition($conditionType->getManifestClass());

        /** @var AppFlowStepValue $stepValue */
        $stepValue = $this->bugContext->get(ValueType::APP_FLOW_STEP);
        if (false === $stepValue->sameStep($bug->condition->evalAtStep())) {
            return;
        }


        foreach ($manifestCondition->shouldEvalWithValues() as $valueType) {
            // if no context value to eval against - just skip
            if (false === $this->bugContext->has($valueType)) {
                continue;
            }

            $bug->condition->evaluate($this->bugContext->get($valueType));

            // once is satisfied - break loop
            if ($bug->condition->isSatisfied()) {
                break;
            }
        }
    }
}
