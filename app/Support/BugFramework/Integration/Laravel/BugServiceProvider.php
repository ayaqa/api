<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel;

use AyaQA\Support\BugFramework\Bug\BugFactory;
use AyaQA\Support\BugFramework\Bug\Event\SetParameter;
use AyaQA\Support\BugFramework\Bug\Listener\ApplyAfterConditionsEval;
use AyaQA\Support\BugFramework\Bug\Listener\SetParameterHandler;
use AyaQA\Support\BugFramework\Bug\Service\ReplacedParameters;
use AyaQA\Support\BugFramework\Condition\ConditionManager;
use AyaQA\Support\BugFramework\Condition\Event\ConditionsEvaluated;
use AyaQA\Support\BugFramework\Condition\Listener\EvalOnAppStepUpdated;
use AyaQA\Support\BugFramework\Condition\Listener\RemoveNonTargetBugs;
use AyaQA\Support\BugFramework\Condition\Resolver\ConditionResolver;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Context\BugContextSetter;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;
use AyaQA\Support\BugFramework\Context\Event\SetContextValue;
use AyaQA\Support\BugFramework\Context\Listener\SetContextValueHandler;
use AyaQA\Support\BugFramework\Integration\Laravel\Middleware\PostController;
use AyaQA\Support\BugFramework\Integration\Laravel\Middleware\PreController;
use AyaQA\Support\BugFramework\Integration\Laravel\Middleware\RequestContextSetter;
use AyaQA\Support\BugFramework\Integration\Laravel\Storage\BugDatabaseService;
use AyaQA\Support\BugFramework\Integration\Laravel\Storage\BugStorageService;
use AyaQA\Support\BugFramework\Value\Factory\ValueFactory;
use Event;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BugServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->registerBindings();
        $this->registerListeners();

        $router->middlewareGroup('buggable', [
            RequestContextSetter::class,
            PreController::class,
            PostController::class
        ]);
    }

    protected function registerBindings()
    {
        $this->registerSingletons();
        $this->app->bind(BugStorageService::class, BugDatabaseService::class);
    }

    protected function registerListeners()
    {
        $dispatcher = $this->app->get(Dispatcher::class);

        $dispatcher->listen(SetContextValue::class, [SetContextValueHandler::class, 'handleGeneric']);
        $dispatcher->listen(SetContextValue::class, [RemoveNonTargetBugs::class, 'handle']);

        $dispatcher->listen(AppStepUpdated::class, [SetContextValueHandler::class, 'handleAppFlow']);
        $dispatcher->listen(AppStepUpdated::class, [EvalOnAppStepUpdated::class, 'handle']);

        $dispatcher->listen(SetParameter::class, [SetParameterHandler::class, 'handle']);
        $dispatcher->listen(ConditionsEvaluated::class, [ApplyAfterConditionsEval::class, 'handle']);
    }

    protected function registerSingletons()
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

        $this->app->singleton(ConditionManager::class, function(Application $app) {
            $bugs = $app->make(BugStorageService::class)->getBugs();

            return new ConditionManager(
                $app->make(BugFactory::class),
                $app->make(ConditionResolver::class),
                $bugs
            );
        });

        $this->app->singleton(ReplacedParameters::class, function (Application $app) {
            return new ReplacedParameters();
        });
    }
}
