<?php

namespace AyaQA\Support\BugFramework\Context;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Value\Collection\Collection;
use AyaQA\Support\BugFramework\Value\Contract\BugField;
use AyaQA\Support\BugFramework\Value\Factory\ValueFactory;

class BugContextSetter
{
    public function __construct(
        private BugContext $bugContext,
        private ValueFactory $valueFactory
    ) {}

    public function set(BugTarget $target, mixed $data): self
    {
        $value = $this->createValues($target, $data);
        if ($value instanceof Collection) {
            $this->bugContext->setCollection($target, $value);
        } else {
            $this->bugContext->setValue($target, $value);
        }

        return $this;
    }

    public function createValues(BugTarget $target, mixed $data): BugField
    {
        return match ($target) {
            BugTarget::PARAMETER => $this->valueFactory->createCollection($target, $data),
            BugTarget::RESOURCE_ID => $this->valueFactory->createResourceId($data),
            // @TODO Custom exception
            default => throw new \RuntimeException(
                sprintf('Target type %s is not mapped to factory.', $target->asString())
            )
        };
    }
}
