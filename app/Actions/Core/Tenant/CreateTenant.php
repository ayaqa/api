<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Models\Core\Tenant;
use AyaQA\Repositories\Core\TenantRepository;

class CreateTenant
{
    public function __construct(private TenantRepository $tenantRepository)
    {
    }

    public function handle(): Tenant
    {
        // @TODO check if is allowed to create tenant, once settings are implemented

        return $this->tenantRepository->create(
            sprintf('test-%s.sqlite', mt_rand(100, 500000)),
            \Ramsey\Uuid\Uuid::uuid4()->toString()
        );
    }
}
