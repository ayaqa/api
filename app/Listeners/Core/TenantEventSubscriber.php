<?php

namespace AyaQA\Listeners\Core;

use AyaQA\Contracts\Support\DatabaseManager;
use AyaQA\Events\Core\TenantCreated;
use AyaQA\Events\Core\TenantDeleted;
use AyaQA\Jobs\Core\ProvisionTenant;

class TenantEventSubscriber
{
    public function __construct(private DatabaseManager $databaseManager)
    {
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array
     */
    public function subscribe()
    {
        return [
            TenantCreated::class => 'handleCreated',
            TenantDeleted::class => 'handleDelete',
        ];
    }

    public function handleCreated(TenantCreated $tenantCreated)
    {
        $tenant = $tenantCreated->getTenant();

        ProvisionTenant::dispatch($tenant);
    }

    public function handleDelete(TenantDeleted $tenantDeleted)
    {
        $tenant = $tenantDeleted->getTenant();

        $this->databaseManager->deleteDatabase($tenant);
    }
}
