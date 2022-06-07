<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\InvocableAction;
use AyaQA\Contracts\Action;
use AyaQA\Models\Core\Tenant;

class ToggleDeletableTenantAction implements Action
{
    use InvocableAction;

    public function handle(Tenant $tenant)
    {
        $tenant->deletable = !$tenant->deletable;
        $tenant->save();

        return $tenant;
    }
}
