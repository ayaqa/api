<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Actions\Core\Tenant\CreateTenantAction;
use AyaQA\Actions\Core\Tenant\DeleteTenantAction;
use AyaQA\Actions\Core\Tenant\GetTenantAction;
use AyaQA\Actions\Core\Tenant\ToggleDeletableTenantAction;
use AyaQA\Concerns\ResponseTrait;
use Illuminate\Http\JsonResponse;

class TenantController
{
    use ResponseTrait;

    public function get(
        GetTenantAction $getTenantAction,
        string $sessionIdentifier
    ): JsonResponse {
        return $this->respond(
            $getTenantAction($sessionIdentifier)
        );
    }

    public function create(
        CreateTenantAction $createTenantAction
    ): JsonResponse {
        return $this->respond(
            $createTenantAction()
        );
    }

    public function delete(
        GetTenantAction    $getTenantAction,
        DeleteTenantAction $deleteTenantAction,
        string             $sessionIdentifier,
    ): JsonResponse {
        return $this->respond(
            $deleteTenantAction($getTenantAction($sessionIdentifier))
        );
    }

    public function deletable(
        GetTenantAction             $getTenantAction,
        ToggleDeletableTenantAction $toggleDeletableTenantAction,
        string                      $sessionIdentifier
    ): JsonResponse {
        return $this->respond(
            $toggleDeletableTenantAction($getTenantAction($sessionIdentifier))
        );
    }
}
