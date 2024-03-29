<?php

namespace AyaQA\Commands\Core;

use AyaQA\Actions\Core\Tenant\DeleteTenantAction as DeleteTenantAction;
use AyaQA\Actions\Core\Tenant\GetTenantAction;
use AyaQA\Actions\Core\Tenant\GetTenantsForAutoDeleteAction;
use AyaQA\Models\Core\Tenant;
use Illuminate\Console\Command;

class DeleteTenantCmd extends Command
{
    public function __construct(
        private DeleteTenantAction            $deleteTenantAction,
        private GetTenantsForAutoDeleteAction $getTenantsForAutoDeleteAction,
        private GetTenantAction               $getTenantAction
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
            $tenant = $this->getTenantAction->handle($tenantId);

            $this->deleteTenant($tenant);
        }
    }

    protected function handleAutoDeleting()
    {
        $tenants = $this->getTenantsForAutoDeleteAction->handle();
        $this->warn(sprintf('Found %s sessions for auto delete.', $tenants->count()));
        $tenants->each(function(Tenant $tenant) {
            $this->deleteTenant($tenant);
        });
    }

    protected function deleteTenant(Tenant $tenant)
    {
        $this->info(sprintf('Delete session: %s (%s)', $tenant->id, $tenant->session));
        $this->deleteTenantAction->handle($tenant);
    }
}
