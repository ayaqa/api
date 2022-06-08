<?php

namespace AyaQA\Jobs\Core;

use Artisan;
use AyaQA\Contracts\Support\DatabaseManager;
use AyaQA\Enum\Core\TenantState;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Models\Core\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProvisionTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Tenant $tenant){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DatabaseManager $db): void
    {

        $this->tenant->setState(TenantState::PROVISIONING);

        try {
            $this->createTenantDb($db);
            $this->migrateTenant();
            $this->seedTenant();

            $this->tenant->setState(TenantState::READY);
        } catch (TenantException) {
            $this->tenant->setState(TenantState::PROVISIONING_FAILED);
        }
    }

    protected function createTenantDb(DatabaseManager $db): void
    {
        $db->createDatabase($this->tenant);
        if (false === $db->exists($this->tenant)) {
            throw new TenantException(
                sprintf('Tenant DB %s was not created.', $this->tenant->id)
            );
        }
    }

    protected function migrateTenant(): void
    {
        $result = Artisan::call(
            'tenants:artisan',
            [
                'artisanCommand' => 'migrate --path=database/migrations/tenant --database=tenant',
                '--tenant' => $this->tenant->id
            ]
        );

        if (0 != $result) {
            throw new TenantException(
                sprintf('Tenant Migration failed for ID: %s', $this->tenant->id)
            );
        }
    }

    protected function seedTenant(): void
    {
        $result = Artisan::call(
            'tenants:artisan',
            [
                'artisanCommand' => 'migrate --database=tenant --seed',
                '--tenant' => $this->tenant->id
            ]
        );

        if (0 != $result) {
            throw new TenantException(
                sprintf('Tenant Seeder failed for ID: %s', $this->tenant->id)
            );
        }
    }
}
