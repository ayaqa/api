<?php

namespace AyaQA\Listeners\Core;

use AyaQA\Events\Core\TenantCreated;
use AyaQA\Jobs\Core\ProvisionTenant;

class TenantEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @return array
     */
    public function subscribe()
    {
        return [
            TenantCreated::class => 'handleCreated',
        ];
    }

    public function handleCreated(TenantCreated $tenantCreated)
    {
        $tenant = $tenantCreated->getTenant();

        ProvisionTenant::dispatch($tenant);
    }
}
