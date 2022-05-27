<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Models\Core\Tenant;

class CreateTenant
{
    public function handle(): Tenant
    {
        // @TODO check if is allowed to create tenant, once settings are implemented

        $tenant = new \AyaQA\Models\Core\Tenant();
        $tenant->database = sprintf('test-%s.sqlite', mt_rand(100, 500000));
        $tenant->session = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $tenant->state = 'created';

        $tenant->save();

        return $tenant;
    }
}
