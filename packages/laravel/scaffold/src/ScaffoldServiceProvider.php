<?php

declare(strict_types=1);

namespace Honed\Scaffold;

use Honed\Scaffold\Commands\ScaffoldCommand;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/scaffold.php', 'scaffold');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/scaffold.php' => config_path('scaffold.php'),
        ], 'scaffold-config');

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ScaffoldCommand::class
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/scaffold.php' => config_path('scaffold.php'),
        ], 'scaffold-config');

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'scaffold-stubs');
    }
}