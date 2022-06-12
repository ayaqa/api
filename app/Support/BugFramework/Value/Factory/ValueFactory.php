<?php

namespace AyaQA\Support\BugFramework\Value\Factory;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Value\Collection\Collection;
use AyaQA\Support\BugFramework\Value\Parameter;
use AyaQA\Support\BugFramework\Value\ResourceId;
use RuntimeException;

class ValueFactory
{
    public function create(BugTarget $target, ...$args)
    {
        $methodName =  match ($target) {
            BugTarget::RESOURCE_ID => 'createResourceId',
            BugTarget::PARAMETER => 'createParameter',

            // @TODO Custom exception
            default => throw new RuntimeException(
                sprintf(
                    'Not able to create instance for %s target.',
                    $target->name
                )
            ),
        };

        if (false === method_exists($this, $methodName)) {
            throw new RuntimeException(
                sprintf('Not found method mapped %s', $methodName)
            );
        }

        return call_user_func_array([$this, $methodName], $args);
    }

    public function createCollection(BugTarget $target, array $data)
    {
        $collection = [];
        foreach ($data as $dataIdx => $dataRow) {

            if (is_array($dataRow)) {
                $arguments = [$target, ...$dataRow];
            } else if(false === is_int($dataIdx)) {
                $arguments = [$target, $dataIdx, $dataRow];
            } else {
                $arguments = [$target, $dataRow];
            }

            $collection[] = call_user_func_array([$this, 'create'], $arguments);
        }

        return new Collection($target->asValueClass(), $collection);
    }

    public function createResourceId(string $resourceId): ResourceId
    {
        return new ResourceId($resourceId);
    }

    public function createParameter(string $name, int|string|bool $value): Parameter
    {
        return new Parameter($name, $value);
    }
}
