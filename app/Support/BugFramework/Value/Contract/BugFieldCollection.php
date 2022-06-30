<?php

namespace AyaQA\Support\BugFramework\Value\Contract;

interface BugFieldCollection extends BugField
{
    public function getValueType(): string;
}
