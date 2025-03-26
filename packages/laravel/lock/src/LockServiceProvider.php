<?php

declare(strict_types=1);

namespace Honed\Lock;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/lock.php', 'lock'
        );

        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/lock.php' => config_path('lock.php'),
            ], 'config');
        }
    }

    /**
     * Register the middleware alias.
     */
    protected function registerMiddleware(): void
    {
        Route::aliasMiddleware('lock', Middleware\ShareLock::class);
    }
}
