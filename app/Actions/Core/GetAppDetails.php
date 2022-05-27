<?php

namespace AyaQA\Actions\Core;

use AyaQA\Actions\Core\Tenant\GetCurrentTenant;
use AyaQA\Exceptions\Core\NotFoundTenantException;

class GetAppDetails
{
    public function __construct(private GetCurrentTenant $getCurrentTenant)
    {
    }

    public function handle(): array
    {
        // @TODO add more info and convert it to DTO
        return [
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
            ],
        ];
    }
}
