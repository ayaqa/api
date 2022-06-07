<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\InvocableAction;
use AyaQA\Contracts\Action;
use AyaQA\Enum\Core\TenantState;
use AyaQA\Events\Core\TenantDeleted;
use AyaQA\Models\Core\Tenant;

class DeleteTenantAction implements Action
{
    use InvocableAction;

    public function __construct(){}

    public function handle(Tenant $tenant): array
    {
        $tenant->state = TenantState::DELETING;
        $tenant->delete();
        $tenant->save();

        TenantDeleted::dispatch($tenant);

        return [
            'success' => true,
            'message' => __('tenant.scheduled_for_delete', ['id' => $tenant->id]),
            'tenant' => $tenant,
        ];
    }
}
