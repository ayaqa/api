<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel;

use AyaQA\Support\BugFramework\BugManager;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Integration\Laravel\Middleware\BugsInRequest;
use AyaQA\Support\BugFramework\Integration\Laravel\Middleware\RequestValuesToContext;
use AyaQA\Support\BugFramework\Rule\BugRules;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BugServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->app->singleton(BugContext::class, function () {
            return new BugContext();
        });

        $this->app->singleton(BugRules::class, function () {
            return new BugRules();
        });

        $this->app->singleton(BugManager::class, function ($app) {
            return new BugManager(
                $app->make(BugContext::class),
                $app->make(BugRules::class)
            );
        });

        $router->middlewareGroup('bug.all', [
            RequestValuesToContext::class,
            BugsInRequest::class,
        ]);
    }
}
