<?php

declare(strict_types=1);

namespace Honed\Lang;

use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lang.php', 'lang');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/lang.php' => config_path('lang.php'),
        ], 'lang-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}