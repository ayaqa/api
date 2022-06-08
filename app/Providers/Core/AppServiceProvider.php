<?php

namespace AyaQA\Providers\Core;

use AyaQA\Contracts\Support\DatabaseManager;
use AyaQA\Data\AppContext;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Support\Core\Multitenancy\DatabaseManager\SqliteDatabaseManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootDatabaseManager();

        /// @TODO move it
        $this->app->singleton(AppContext::class, function() {
            return AppContext::build();
        });
    }

    private function bootDatabaseManager()
    {
        $this->app->singleton(DatabaseManager::class, function(Application $app) {
            $driverName = $app->get('db')->getDriverName();
            if ($driverName == 'sqlite') {
                return $this->app->get(SqliteDatabaseManager::class);
            }

            throw TenantException::noDriver($driverName);
        });
    }
}
