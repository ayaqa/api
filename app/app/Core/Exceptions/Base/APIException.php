<?php

namespace AyaQA\Core\Exceptions\Base;

use AyaQA\Core\Exceptions\Contract\AyaQAException;
use RuntimeException;

abstract class APIException extends RuntimeException implements AyaQAException
{
}
