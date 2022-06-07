<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\InvocableAction;
use AyaQA\Contracts\Action;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Models\Core\Tenant;
use AyaQA\Services\Core\TenantService;
use AyaQA\Settings\Core\CoreSettings;

class CreateTenantAction implements Action
{
    use InvocableAction;

    public function __construct(
        private TenantService $tenantService,
        private CoreSettings $coreSettings
    ){}

    public function handle(): Tenant
    {
        if (false === $this->tenantService->canCreateSession()) {
            throw TenantException::maxTenant($this->coreSettings->sessionsLimit);
        }

        return $this->tenantService->create();
    }
}
