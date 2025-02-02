<?php

declare(strict_types=1);

namespace Honed\Flash;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flash.php', 'flash');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/flash.php' => config_path('flash.php'),
        ], 'flash-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }

        // RedirectResponse::macro('')
    }
}