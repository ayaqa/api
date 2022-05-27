<?php

namespace AyaQA\Enum\Core;

enum TenantStatus: string
{
    case CREATED = 'created';
    case PROVISIONING = 'provisioning';
    case PROVISIONING_FAILED = 'failed';
    case READY = 'ready';
    case DELETING = 'deleting';
}
