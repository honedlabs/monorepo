<?php

declare(strict_types=1);

namespace Honed\Flash;

use Inertia\ResponseFactory;
use Honed\Flash\Facades\Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
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
            string|null $type = null,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::message(...\func_get_args());
            return $this;
        });

        RedirectResponse::macro('success', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::success(...\func_get_args());
            return $this;
        });

        RedirectResponse::macro('error', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::error(...\func_get_args());
            return $this;
        });

        RedirectResponse::macro('info', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::info(...\func_get_args());
            return $this;
        });

        RedirectResponse::macro('warning', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            Flash::warning(...\func_get_args());
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
            string|null $type = null,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::message(...\func_get_args());
            return $this;
        });

        ResponseFactory::macro('success', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::success(...\func_get_args());
            return $this;
        });

        ResponseFactory::macro('error', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::error(...\func_get_args());
            return $this;
        });

        ResponseFactory::macro('info', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::info(...\func_get_args());
            return $this;
        });

        ResponseFactory::macro('warning', function (
            string $message,
            string|null $title = null,
            int|null $duration = null,
            array $meta = []
        ) {
            /** @var \Inertia\ResponseFactory $this */
            Flash::warning(...\func_get_args());
            return $this;
        });
    }
}