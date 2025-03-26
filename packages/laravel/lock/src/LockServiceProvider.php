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
        $this->registerMiddleware();
    }

    /**
     * Register the middleware alias.
     */
    protected function registerMiddleware(): void
    {
        Route::aliasMiddleware('lock', Middleware\ShareLock::class);
    }
}
