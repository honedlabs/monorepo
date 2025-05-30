<?php

declare(strict_types=1);

namespace Honed\Lock;

use Honed\Lock\Contracts\Lockable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var class-string<Lockable>
         */
        $locker = config('lock.implementation', Locker::class);

        $this->app->singleton($locker);

        $this->app->bind(Lockable::class, $locker);

        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register the middleware alias.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        Route::aliasMiddleware('lock', Middleware\ShareLock::class);
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/lock.php' => config_path('lock.php'),
        ], 'lock-config');
    }
}
