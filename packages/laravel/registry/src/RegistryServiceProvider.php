<?php

declare(strict_types=1);

namespace Honed\Registry;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Honed\Registry\Commands\RegistryMakeCommand;
use Honed\Registry\Commands\RegistryBuildCommand;
use Honed\Registry\Commands\RegistryClearCommand;
use Honed\Registry\Commands\RegistryItemMakeCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RegistryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/registry.php', 'registry');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerMacros();

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->optimizes(RegistryBuildCommand::class);

            $this->commands([
                RegistryBuildCommand::class,
                RegistryClearCommand::class,
                RegistryItemMakeCommand::class,
                RegistryMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the macros for the package.
     *
     * @return void
     */
    protected function registerMacros()
    {
        App::macro('getRegistryPath', function () {
            /** @var \Illuminate\Foundation\Application $this */
            return $this->normalizeCachePath('APP_REGISTRY_CACHE', 'cache/registry.json');
        });

        App::macro('hasRegistry', function () {
            /** @var \Illuminate\Foundation\Application $this */
            return $this->files->exists($this->getRegistryPath());
        });

        Router::macro('registry', function (string $name, string $registry) {
            /** @var \Illuminate\Routing\Router $this */
            return $this->get($name);
        });
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/registry.php' => config_path('registry.php'),
        ], 'registry-config');

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'registry-stubs');
    }
}