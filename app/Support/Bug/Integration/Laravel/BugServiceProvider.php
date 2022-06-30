<?php

namespace AyaQA\Support\Bug\Integration\Laravel;

use AyaQA\Support\Bug\Context\BugContext;
use AyaQA\Support\Bug\Context\BugContextSetter;
use AyaQA\Support\Bug\Field\Factory\FieldFactory;
use AyaQA\Support\Bug\Integration\Laravel\Middleware\SetContextFromRequest;
use AyaQA\Support\Bug\Integration\Laravel\Middleware\TemporaryTesting;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BugServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->app->singleton(BugContext::class, function() {
            return new BugContext();
        });

        $this->app->singleton(BugContextSetter::class, function(Application $app) {
            return new BugContextSetter(
                $app->make(FieldFactory::class),
                $app->make(BugContext::class)
            );
        });

        $router->middlewareGroup('bug.all', [
            SetContextFromRequest::class,
            TemporaryTesting::class,
        ]);
    }
}
