<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use AyaQA\Actions\Core\Tenant\CreateTenant;
use AyaQA\Actions\Core\Tenant\GetCurrentTenant;
use Illuminate\Http\Request;

class TenantController extends ApiController
{
    public function current(GetCurrentTenant $fetchCurrent)
    {
        $tenant = $fetchCurrent->handle();

        return response()->json($tenant->toArray());
    }

    public function create(CreateTenant $createTenant)
    {
        $tenant = $createTenant->handle();

        return response()->json($tenant);
    }

    public function delete(Request $request)
    {
        // @TODO perform delete
    }
}
