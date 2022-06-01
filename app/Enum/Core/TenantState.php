<?php

namespace AyaQA\Enum\Core;

enum TenantState: string
{
    case CREATED = 'created';
    case PROVISIONING = 'provisioning';
    case PROVISIONING_FAILED = 'failed';

    case DELETING = 'deleting';

    case READY = 'ready';
}
