<?php

declare(strict_types=1);

namespace Honed\Disable;

use Illuminate\Support\ServiceProvider;

class DisableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/disable.php', 'disable');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/disable.php' => config_path('disable.php'),
        ], 'disable-config');
    }
}