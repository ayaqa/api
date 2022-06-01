<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Enum\Core\TenantState;
use AyaQA\Events\Core\TenantDeleted;
use AyaQA\Models\Core\Tenant;
use AyaQA\Repositories\Core\TenantRepository;

class DeleteTenant
{
    public function __construct(private TenantRepository $tenantRepository)
    {
    }

    public function handle(Tenant $tenant)
    {
        $this->tenantRepository->delete($tenant);

        TenantDeleted::dispatch($tenant);
    }
}
