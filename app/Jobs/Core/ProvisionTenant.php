<?php

namespace AyaQA\Jobs\Core;

use Artisan;
use AyaQA\Contracts\Core\DatabaseManager;
use AyaQA\Enum\Core\TenantStatus;
use AyaQA\Exceptions\Core\AyaQAException;
use AyaQA\Models\Core\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProvisionTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Tenant $tenant)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DatabaseManager $db)
    {
        $this->setStatus(TenantStatus::PROVISIONING);

        try {
            $this->createTenantDb($db);
            $this->migrateTenant();
            $this->seedTenant();

            $this->setStatus(TenantStatus::READY);
        } catch (AyaQAException $throwable) {
            $this->setStatus(TenantStatus::PROVISIONING_FAILED);
        }
    }

    protected function setStatus(TenantStatus $status)
    {
        $this->tenant->state = $status->value;
        $this->tenant->save();
    }

    protected function createTenantDb(DatabaseManager $db): void
    {
        $db->createDatabase($this->tenant);
        if (false === $db->exists($this->tenant)) {
            throw new AyaQAException(sprintf('Tenant DB %s was not created.', $this->tenant->id));
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
            throw new AyaQAException(sprintf('Tenant Migration failed for ID: %s', $this->tenant->id));
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
            throw new AyaQAException(sprintf('Tenant Seeder failed for ID: %s', $this->tenant->id));
        }
    }
}
