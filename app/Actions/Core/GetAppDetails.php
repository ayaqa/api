<?php

namespace AyaQA\Actions\Core;

use AyaQA\Actions\Core\Tenant\GetCurrentTenantAction;
use AyaQA\Concerns\InvocableAction;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Settings\Core\CoreSettings;
use AyaQA\Settings\Core\TenantSettings;

class GetAppDetails
{
    use InvocableAction;

    public function __construct(
        private GetCurrentTenantAction $getCurrentTenantAction,
        private CoreSettings           $coreSettings,
        private TenantSettings         $tenantSettings
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
            $tenant = $this->getCurrentTenantAction->handle();
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
