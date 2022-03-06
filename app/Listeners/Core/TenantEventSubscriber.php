<?php

namespace AyaQA\Listeners\Core;

use Artisan;
use AyaQA\Contracts\Core\DatabaseManager;
use AyaQA\Events\Core\TenantCreated;
use AyaQA\Models\Core\Tenant;
use Illuminate\Events\Dispatcher;

class TenantEventSubscriber
{
    public function __construct(private DatabaseManager $db)
    {
    }

    public function handleCreated(TenantCreated $tenantCreated)
    {
        $tenant = $tenantCreated->getTenant();

        $this->createTenantDb($tenant);
        $this->migrateTenant($tenant);
        $this->seedTenant($tenant);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {
        return [
            TenantCreated::class => 'handleCreated',
        ];
    }

    protected function createTenantDb(Tenant $tenant): void
    {
        $this->db->createDatabase($tenant);
        if (false === $this->db->exists($tenant)) {
            // @TODO Add custom exception
            throw new \RuntimeException(sprintf('Tenant DB %s was not created.', $tenant->id));
        }
    }

    protected function migrateTenant(Tenant $tenant): void
    {
        $result = Artisan::call(
            'tenants:artisan',
            [
                'artisanCommand' => 'migrate --path=database/migrations/tenant --database=tenant',
                '--tenant' => $tenant->id
            ]
        );

        if (0 != $result) {
            // @TODO Add custom exception
            throw new \RuntimeException(sprintf('Tenant Migration failed for ID: %s', $tenant->id));
        }
    }

    protected function seedTenant(Tenant $tenant): void
    {
        $result = Artisan::call(
            'tenants:artisan',
            [
                'artisanCommand' => 'migrate --database=tenant --seed',
                '--tenant' => $tenant->id
            ]
        );

        if (0 != $result) {
            // @TODO Add custom exception
            throw new \RuntimeException(sprintf('Tenant Seeder failed for ID: %s', $tenant->id));
        }
    }
}
