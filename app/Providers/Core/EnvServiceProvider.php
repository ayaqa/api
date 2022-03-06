<?php

namespace AyaQA\Providers\Core;

use Illuminate\Support\ServiceProvider;

class EnvServiceProvider extends ServiceProvider
{
    const DEV_ONLY_PROVIDERS = [
        // @TODO add dev packages
    ];

    public function register()
    {
        $this->registerEnvProviders('local', self::DEV_ONLY_PROVIDERS);
    }

    protected function registerEnvProviders(string $env, array $providerClasses)
    {
        if (false === $this->app->environment($env)) {
            return;
        }

        foreach ($providerClasses as $providerClass) {
            $this->app->register($providerClass);
        }
    }
}
