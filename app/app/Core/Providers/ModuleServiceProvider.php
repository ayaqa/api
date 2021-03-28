<?php

namespace AyaQA\Core\Providers;

use AyaQA\Core\Contract\Module\ModuleInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modules = Config::get('modules.enabled');
        foreach ($modules as $module) {
            $moduleObject = $this->createInstance($module);

            $this->bindModule($moduleObject);
            $this->registerServiceProviders($moduleObject);
        }
    }

    /**
     * @param ModuleInterface $module
     */
    protected function bindModule(ModuleInterface $module)
    {
        $this->app->instance($module::class, $module);
        $this->app->tag($module::class, [ModuleInterface::CONTAINER_MODULES_TAG]);
    }

    /**
     * @param ModuleInterface $module
     */
    protected function registerServiceProviders(ModuleInterface $module)
    {
        foreach ($module->getProviders() as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * @param string $module
     *
     * @return ModuleInterface
     */
    protected function createInstance(string $module): ModuleInterface
    {
        $object = new $module;
        if (false === $object instanceof ModuleInterface) {
            throw new \LogicException(sprintf('Module class should implements %s interface.', ModuleInterface::class));
        }

        return $object;
    }
}
