<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\CommandAction;
use AyaQA\Models\Core\Tenant;

class ToggleDeletableTenantAction implements CommandAction
{
    use Invocable;

    public function handle(Tenant $tenant)
    {
        $tenant->deletable = !$tenant->deletable;
        $tenant->save();

        return $tenant;
    }
}
