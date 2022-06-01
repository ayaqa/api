<?php

namespace AyaQA\Events\Core;

use AyaQA\Models\Core\Tenant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TenantDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(private Tenant $tenant)
    {
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }
}
