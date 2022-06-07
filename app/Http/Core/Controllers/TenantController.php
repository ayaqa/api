<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use AyaQA\Actions\Core\Tenant\CreateTenant;
use AyaQA\Actions\Core\Tenant\DeleteTenant;
use AyaQA\Actions\Core\Tenant\GetTenant;
use AyaQA\Actions\Core\Tenant\ToggleDeletableTenant;
use Illuminate\Http\JsonResponse;

class TenantController extends ApiController
{
    public function get(GetTenant $getTenant, string $sessionIdentifier): JsonResponse
    {
        return $this->respond(
            $getTenant($sessionIdentifier)
        );
    }

    public function create(CreateTenant $createTenantAction): JsonResponse
    {
        return $this->respond(
            $createTenantAction()
        );
    }

    public function delete(
        GetTenant $getTenantAction,
        DeleteTenant $deleteTenantAction,
        string $sessionIdentifier,
    ): JsonResponse {
        return $this->respond(
            $deleteTenantAction($getTenantAction($sessionIdentifier))
        );
    }

    public function deletable(
        GetTenant $getTenantAction,
        ToggleDeletableTenant $toggleDeletableTenant,
        string $sessionIdentifier
    ): JsonResponse {
        return $this->respond(
            $toggleDeletableTenant($getTenantAction($sessionIdentifier))
        );
    }
}
