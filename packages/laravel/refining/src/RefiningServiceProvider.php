<?php

declare(strict_types=1);

namespace Honed\Refining;

use Illuminate\Support\ServiceProvider;

class RefiningServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/refining.php', 'refining');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/refining.php' => config_path('refining.php'),
        ], 'refining-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}
