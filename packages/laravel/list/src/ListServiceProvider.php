<?php

declare(strict_types=1);

namespace Honed\List;

use Illuminate\Support\ServiceProvider;

class ListServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/list.php', 'list');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/list.php' => config_path('list.php'),
        ], 'list-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}