<?php

namespace AyaQA\Support\BugFramework\Bug\Service;

use AyaQA\Support\BugFramework\Condition\ConditionType;
use AyaQA\Support\BugFramework\ConfiguredBug;
use AyaQA\Support\BugFramework\ConfiguredBugs;

class UIBugsFormatter
{
    public function toArray(ConfiguredBugs $bugs): array
    {
        $formatted = [];
        foreach ($bugs as $bug) {
            /** @var ConfiguredBug $bug */

            $bugId = $bug->bug->getId();

            if (false === isset($formatted[$bugId])) {
                $formatted[$bugId] = [];
            }

            $formatted[$bugId][$this->getHash($bug)] = $this->formatValue($bug);
        }

        return $formatted;
    }

    protected function getHash(ConfiguredBug $bug): string
    {
        $configKey = $bug->bug->getConfig()->getKey();
        if (empty($configKey)) {
            return $bug->target->value();
        }

        return sprintf('%s|%s', $bug->target->value(), $configKey);
    }

    protected function formatValue(ConfiguredBug $bug): array
    {
        return [
            'isAlways'  => $bug->condition->getType() === ConditionType::ALWAYS,
            'bugConfig'  => $bug->bug->getConfig()->toArray(),
            'conditionConfig' => $bug->condition->getConfig()->toArray()
        ];
    }
}
