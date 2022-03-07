<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use Illuminate\Http\Request;

class TenantController extends ApiController
{
    public function create(Request $request)
    {
        // @TODO perform checks and create new
        // @TODO move that logic to service

        $tenant = new \AyaQA\Models\Core\Tenant();
        $tenant->database = sprintf('test-%s.sqlite', mt_rand(100, 500000));
        $tenant->session = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $tenant->state = 'created';

        $tenant->save();

        return response()->json($tenant);
    }

    public function delete(Request $request)
    {
        // @TODO perform delete
    }
}
