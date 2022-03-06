<?php

namespace AyaQA\Services\Core\Multitenancy\DatabaseManager;

use AyaQA\Contracts\Core\DatabaseManager;
use Spatie\Multitenancy\Models\Tenant;
use Throwable;

class SqliteDatabaseManager implements DatabaseManager
{
    /**
     * @param string $dbName
     *
     * @return string
     */
    public static function getDatabasePath(string $dbName = ''): string
    {
        $rootPath = sprintf('%s/tenant', env('DB_SQLITE_PATH', database_path('sqlite')));
        if (false === is_dir($rootPath) || false === is_writable($rootPath)) {
            // @TODO fix with custom exception
            throw new \RuntimeException('not dir or not writeable');
        }

        return '' === $dbName ? $rootPath : sprintf('%s/%s', $rootPath, $dbName);
    }

    /**
     * @param Tenant $tenant
     *
     * @return bool
     */
    public function createDatabase(Tenant $tenant): bool
    {
        if ($this->exists($tenant)) {
            return true;
        }

        try {
            // @TODO it may already exists
            return (bool) file_put_contents(self::getDatabasePath($tenant->getDatabaseName()), '');
        } catch (Throwable $e) {
            // @TODO log it
            return false;
        }
    }

    /**
     * @param Tenant $tenant
     *
     * @return bool
     */
    public function deleteDatabase(Tenant $tenant): bool
    {
        try {
            return unlink(self::getDatabasePath($tenant->getDatabaseName()));
        } catch (Throwable $e) {
            // @TODO log it

            return false;
        }
    }

    /**
     * @param Tenant $tenant
     *
     * @return bool
     */
    public function exists(Tenant $tenant): bool
    {
        return file_exists(self::getDatabasePath($tenant->getDatabaseName()));
    }
}
