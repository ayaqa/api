<?php

namespace AyaQA\Actions\Core;

use AyaQA\Actions\Core\Tenant\GetCurrentTenant;
use AyaQA\Concerns\InvocableAction;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Settings\Core\CoreSettings;
use AyaQA\Settings\Core\TenantSettings;

class GetAppDetails
{
    use InvocableAction;

    public function __construct(
        private GetCurrentTenant $getCurrentTenant,
        private CoreSettings $coreSettings,
        private TenantSettings $tenantSettings
    ){}

    public function handle(): array
    {
        return [
            'settings' => $this->coreSettings->refresh()->toArray(),
            ...$this->getSessionDetails()
        ];
    }

    private function getSessionDetails(): array
    {
        try {
            $tenant = $this->getCurrentTenant->handle();
        } catch (NotFoundTenantException) {
            return [];
        }

        return [
            'session' => [
                ...$tenant->toArray(),
                'settings' => $this->tenantSettings->refresh()->toArray()
            ],
        ];
    }
}
