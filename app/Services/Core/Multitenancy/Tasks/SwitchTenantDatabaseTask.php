<?php

namespace AyaQA\Services\Core\Multitenancy\Tasks;

use AyaQA\Services\Core\Multitenancy\DatabaseManager\SqliteDatabaseManager;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Exceptions\InvalidConfiguration;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchTenantDatabaseTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(Tenant $tenant): void
    {
        $this->setTenantConnectionDatabaseName($tenant->getDatabaseName());
    }

    public function forgetCurrent(): void
    {
        $this->setTenantConnectionDatabaseName(null);
    }

    protected function setTenantConnectionDatabaseName(?string $databaseName)
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();
        if ($tenantConnectionName === $this->landlordDatabaseConnectionName()) {
            throw InvalidConfiguration::tenantConnectionIsEmptyOrEqualsToLandlordConnection();
        }

        if (is_null(config("database.connections.{$tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }

        // make sure path to db is proper when sqlite driver is used.
        if (null !== $databaseName && $this->isSQLite($tenantConnectionName)) {
            $databaseName = SqliteDatabaseManager::getDatabasePath($databaseName);
        }

        config([
            "database.connections.{$tenantConnectionName}.database" => $databaseName,
        ]);

        app('db')->extend($tenantConnectionName, function ($config, $name) use ($databaseName) {
            $config['database'] = $databaseName;

            return app('db.factory')->make($config, $name);
        });

        DB::purge($tenantConnectionName);
    }

    /**
     * @param string $tenantConnectionName
     *
     * @return bool
     *
     * @throws InvalidConfiguration
     */
    protected function isSQLite(string $tenantConnectionName): bool
    {
        $driver = config("database.connections.{$tenantConnectionName}.driver");
        if (is_null($driver)) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }

        return $driver === 'sqlite';
    }
}
