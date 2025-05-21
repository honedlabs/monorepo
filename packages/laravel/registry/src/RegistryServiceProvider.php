<?php

declare(strict_types=1);

namespace Honed\Registry;

use Illuminate\Support\ServiceProvider;
use Honed\Registry\Commands\RegistryMakeCommand;

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
        $this->publishes([
            __DIR__.'/../config/registry.php' => config_path('registry.php'),
        ], 'registry-config');

        if ($this->app->runningInConsole()) {
            // $this->offerPublishing();

            $this->commands([
                // RegistryBuildCommand::class,
                // RegisteryClearCommand::class
                RegistryMakeCommand::class,
            ]);
        }
    }
}