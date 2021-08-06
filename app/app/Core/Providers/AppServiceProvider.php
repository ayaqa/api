<?php

namespace AyaQA\Core\Providers;

use AyaQA\Core\Http\Middleware\PasswordCheckSettingsUpdate;
use AyaQA\Core\Service\AppSettingsService;
use AyaQA\Core\Settings\AppSettings;
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
        $this->app->singleton(AppSettingsService::class, function (Application $app) {
            return new AppSettingsService($app->get(AppSettings::class));
        });

        $this->app->singleton(PasswordCheckSettingsUpdate::class, function(Application $app) {
            return new PasswordCheckSettingsUpdate($app->get(AppSettingsService::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
