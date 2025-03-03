<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Facades\Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\ResponseFactory;

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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/flash.php' => config_path('flash.php'),
            ], 'config');
        }

        $this->registerMiddlewareAlias();
        $this->registerRedirectResponseMacros();
        $this->registerInertiaMacros();

    }

    /**
     * Register the middleware alias for flash messages.
     */
    protected function registerMiddlewareAlias(): void
    {
        Route::aliasMiddleware('flash', Middleware\ShareFlash::class);
    }

    /**
     * Register the redirect response macros.
     */
    protected function registerRedirectResponseMacros(): void
    {
        RedirectResponse::macro('flash', function (
            string|Message $message,
            ?string $type = null,
            ?string $title = null,
            ?int $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::message($message, $type, $title, $duration, $meta);

            return $this;
        });
    }

    /**
     * Register the inertia response macros.
     */
    protected function registerInertiaMacros(): void
    {
        ResponseFactory::macro('flash', function (
            string|Message $message,
            ?string $type = null,
            ?string $title = null,
            ?int $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::message($message, $type, $title, $duration, $meta);

            return $this;
        });
    }
}
