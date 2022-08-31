<?php

namespace AyaQA\Support\Bug\Integration\Laravel;

use AyaQA\Support\Bug\Context\BugContext;
use AyaQA\Support\Bug\Context\BugContextSetter;
use AyaQA\Support\Bug\Event\NewContextValue;
use AyaQA\Support\Bug\Integration\Laravel\Middleware\RequestContextSetter;
use AyaQA\Support\Bug\Listener\NewContextValueHandler;
use AyaQA\Support\Bug\Value\Factory\ValueFactory;
use Event;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BugServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->registerBindings();
        $this->registerListeners();

        $router->middlewareGroup('buggable', [
            RequestContextSetter::class,
        ]);
    }

    protected function registerBindings()
    {
        $this->app->singleton(BugContext::class, function() {
            return new BugContext();
        });

        $this->app->singleton(BugContextSetter::class, function(Application $app) {
            return new BugContextSetter(
                $app->make(ValueFactory::class),
                $app->make(BugContext::class)
            );
        });
    }

    protected function registerListeners()
    {
        Event::listen(
            NewContextValue::class,
            [NewContextValueHandler::class, 'handle']
        );
    }
}
