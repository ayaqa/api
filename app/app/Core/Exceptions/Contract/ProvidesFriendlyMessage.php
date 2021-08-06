<?php

namespace AyaQA\Core\Exceptions\Contract;

interface ProvidesFriendlyMessage extends AyaQAException
{
    public function getFriendlyMessage(): string;
}
