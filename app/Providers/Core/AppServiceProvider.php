<?php

namespace AyaQA\Providers\Core;

use AyaQA\Contracts\Core\DatabaseManager;
use AyaQA\Dtos\Core\SessionDto;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Services\Core\Multitenancy\DatabaseManager\SqliteDatabaseManager;
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

        $this->app->singleton(SessionDto::class, function() {
            return new SessionDto();
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
