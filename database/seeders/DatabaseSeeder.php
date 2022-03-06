<?php

namespace Database\Seeders;

use AyaQA\Models\Core\Tenant;
use Database\Seeders\Tenant\TogglesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
            ? $this->callTenantSpecificSeeders()
            : $this->callMainSpecificSeeders();
    }

    public function callTenantSpecificSeeders()
    {
        $this->call([
            TogglesSeeder::class,
        ]);
    }

    public function callMainSpecificSeeders()
    {
        // run landlord specific seeders
    }
}
