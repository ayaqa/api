<?php

namespace AyaQA\Providers\Core;

use AyaQA\Contracts\Core\DatabaseManager;
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
        // @TODO move it to different way of loading
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
        // @TODO move it to specific provider
        $this->app->singleton(DatabaseManager::class, function(Application $app) {
            $driverName = $app->get('db')->getDriverName();
            if ($driverName == 'sqlite') {
                return $this->app->get(SqliteDatabaseManager::class);
            }

            // @TODO custom exception
            throw new \Exception('Not Supported');
        });
    }
}
