<?php

namespace AyaQA\Services\Core;

use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;
use AyaQA\Repositories\Core\TenantRepository;
use AyaQA\Settings\Core\CoreSettings;
use Illuminate\Support\Collection;

class TenantService
{
    public function __construct(private TenantRepository $tenantRepository, private CoreSettings $settings)
    {
    }

    /**
     * @throws NotFoundTenantException
     */
    public function get(string $identifier): Tenant
    {
        return $this->tenantRepository->get($identifier);
    }

    public function getReadyForAutoDelete(): Collection
    {
        $tenants = collect();
        if ($this->settings->autoDeleteSession) {
            $tenants = $this->tenantRepository->getAllForAutoDeleting(
                $this->settings->sessionDeleteAfter
            );
        }

        return $tenants;
    }
}
