<?php

namespace AyaQA\Support\BugFramework\Support\Controller;

use AyaQA\Enum\SectionId;

abstract class BuggableController
{
    public abstract static function getSection(): SectionId;
}
