<?php

namespace AyaQA\Commands\Core;

use AyaQA\Actions\Core\Tenant\DeleteTenant as DeleteTenantAction;
use AyaQA\Actions\Core\Tenant\GetTenant;
use AyaQA\Models\Core\Tenant;
use AyaQA\Services\Core\TenantService;
use Illuminate\Console\Command;

class DeleteTenantCmd extends Command
{
    public function __construct(
        private DeleteTenantAction $deleteTenant,
        private TenantService $tenantService,
        private GetTenant $getTenant
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
    protected $description = 'Delete idle sessions or force deleting specific IDS';


    public function handle()
    {
        $idsToDelete = array_values($this->argument('ids'));
        if (empty($idsToDelete)) {
            $this->info('Checking for not used sessions that have to be deleted.');
            $this->handleAutoDeleting();

            return;
        }


        foreach ($idsToDelete as $tenantId) {
            $tenant = $this->getTenant->handle($tenantId);

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
        $this->info(sprintf('Delete session: %s (%s)', $tenant->id, $tenant->session));
        $this->deleteTenant->handle($tenant);
    }
}