<?php

declare(strict_types=1);

namespace Honed\Performance;

use Illuminate\Support\ServiceProvider;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/performance.php', 'performance');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/performance.php' => config_path('performance.php'),
        ], 'performance-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}