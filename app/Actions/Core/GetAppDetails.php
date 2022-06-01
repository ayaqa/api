<?php

namespace AyaQA\Actions\Core;

use AyaQA\Actions\Core\Tenant\GetCurrentTenant;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Settings\Core\CoreSettings;
use AyaQA\Settings\Core\TenantSettings;

class GetAppDetails
{
    public function __construct(
        private GetCurrentTenant $getCurrentTenant,
        private CoreSettings $coreSettings,
        private TenantSettings $tenantSettings
    ){}

    public function handle(): array
    {
        return [
            'settings' => $this->coreSettings->refresh()->toArray(),
            ...$this->formatSessionDetails()
        ];
    }

    private function formatSessionDetails(): array
    {
        try {
            $tenant = $this->getCurrentTenant->handle();
        } catch (NotFoundTenantException) {
            return [];
        }

        return [
            'session' => [
                'id' => $tenant->id,
                'uuid' => $tenant->session,
                'state' => $tenant->state,
                'settings' => $this->tenantSettings->refresh()->toArray()
            ],
        ];
    }
}
