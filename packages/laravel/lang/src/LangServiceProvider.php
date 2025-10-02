<?php

declare(strict_types=1);

namespace Honed\Lang;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Honed\Lang\Middleware\ShareTranslations;

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
        $this->registerMiddleware();

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

    /**
     * Register the middleware for the package.
     */
    protected function registerMiddleware(): void
    {
        $this->app->make(Kernel::class)
            ->pushMiddleware(ShareTranslations::class);
    }
}