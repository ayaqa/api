<?php

namespace AyaQA\Commands\Core;

use AyaQA\Actions\Core\Tenant\DeleteTenant as DeleteTenantAction;
use AyaQA\Models\Core\Tenant;
use AyaQA\Services\Core\TenantService;
use Illuminate\Console\Command;

class DeleteTenantCmd extends Command
{
    public function __construct(
        private DeleteTenantAction $deleteTenant,
        private TenantService $tenantService
    ){
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:delete {ids?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete sessions by IDs';


    public function handle()
    {
        $idsToDelete = array_values($this->argument('ids'));
        if (empty($idsToDelete)) {
            $this->info('Checking for idle sessions that have to be deleted....');
            $this->handleAutoDeleting();

            return;
        }


        foreach ($idsToDelete as $tenantId) {
            $tenant = $this->tenantService->get($tenantId);

            $this->deleteTenant($tenant);
        }
    }

    protected function handleAutoDeleting()
    {
        $tenants = $this->tenantService->getReadyForAutoDelete();
        $this->warn(sprintf('Found %s sessions for auto delete.', $tenants->count()));
        $tenants->each(function(Tenant $tenant) {
            $this->deleteTenant($tenant);
        });
    }

    protected function deleteTenant(Tenant $tenant)
    {
        $this->info(sprintf('Deleting ID: %s, Uuid: %s', $tenant->id, $tenant->session));
        $this->deleteTenant->handle($tenant);
    }
}
