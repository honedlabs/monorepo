<?php

declare(strict_types=1);

namespace Honed\Lock;

use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lock.php', 'lock');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/lock.php' => config_path('lock.php'),
        ], 'lock-config');
    }
}