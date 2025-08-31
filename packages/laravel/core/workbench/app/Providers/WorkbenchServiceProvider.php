<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Workbench\App\Console\Commands\ComponentListCommand;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ComponentListCommand::class
            ]);
        }
    }
}
