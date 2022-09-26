<?php

namespace AyaQA\Support\BugFramework\Support\Contract;

use JsonSerializable;

interface HasToArray extends JsonSerializable
{
    public function toArray(): array;
}
