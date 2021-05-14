<?php

namespace AyaQA\Core\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EnvBasedServiceProvider extends ServiceProvider
{
    const DEV_ONLY_PROVIDERS = [
        IdeHelperServiceProvider::class
    ];

    public function register()
    {
        $this->registerLocalProviders();
    }

    protected function registerLocalProviders()
    {
        if ($this->app->environment('local')) {
            foreach (self::DEV_ONLY_PROVIDERS as $providerClass) {
                $this->app->register($providerClass);
            }
        }
    }
}
