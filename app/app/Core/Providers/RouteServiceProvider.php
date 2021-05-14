<?php

namespace AyaQA\Core\Providers;

use AyaQA\Core\Contract\Module\ModuleInterface;
use AyaQA\Core\Literal\RouteConst;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function map()
    {
        $this->registerDefault();
        $this->registerModuleRoutes();
    }

    public function registerDefault()
    {
        Route::prefix(RouteConst::API_PREFIX)
            ->middleware(RouteConst::API_MIDDLEWARE)
            ->namespace($this->namespace)
            ->group($this->getApiRoutePath('Core'));

        Route::middleware(RouteConst::WEB_MIDDLEWARE)
            ->namespace($this->namespace)
            ->group($this->getWebRoutePath('Core'));
    }

    public function registerModuleRoutes()
    {
        $allModules = $this->app->tagged(ModuleInterface::CONTAINER_MODULES_TAG);

        /** @var ModuleInterface $module */
        foreach ($allModules as $module) {
            $apiPath = $this->getApiRoutePath($module->getModule());
            if (file_exists($apiPath)) {
                Route::prefix(RouteConst::API_PREFIX)
                    ->as($module->getKey().'.')
                    ->group($apiPath);
            }

            $webPath = $this->getWebRoutePath($module->getModule());
            if (file_exists($webPath)) {
                Route::middleware(RouteConst::WEB_MIDDLEWARE)
                    ->as($module->getKey().'.')
                    ->group($webPath);
            }
        }
    }

    protected function getWebRoutePath(string $module): string
    {
        return sprintf(base_path('routes/web/%s/routes.php'), $module);
    }

    protected function getApiRoutePath(string $module): string
    {
        return sprintf(base_path('routes/api/%s/routes.php'), $module);
    }
}
