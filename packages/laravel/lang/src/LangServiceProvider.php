<?php

declare(strict_types=1);

namespace Honed\Lang;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lang.php', 'lang');

        $this->app->alias(LangManager::class, 'lang');

        $this->app->singleton('lang', fn (Application $app) => new LangManager($app));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/lang.php' => config_path('lang.php'),
        ], 'lang-config');
    }
}
