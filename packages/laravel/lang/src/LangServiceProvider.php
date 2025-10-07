<?php

declare(strict_types=1);

namespace Honed\Lang;

use Honed\Lang\Middleware\Localize;
use Honed\Lang\Middleware\ShareTranslations;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
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

        $this->getRouter()->aliasMiddleware('lang', ShareTranslations::class);

        $this->getRouter()->aliasMiddleware('localize', Localize::class);
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

    /**
     * Get the router from the app.
     */
    protected function getRouter(): Router
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->app['router'];
    }
}
