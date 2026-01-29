<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Contracts\Flashable;
use Honed\Flash\Enums\FlashType;
use Honed\Flash\Facades\Flash;
use Honed\Toast\Commands\ToastMakeCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\ResponseFactory;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flash.php', 'flash');

        /** @var class-string<Flashable> */
        $implementation = config('flash.implementation', Toast::class);

        $this->app->bind(Flashable::class, $implementation);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ToastMakeCommand::class,
            ]);
        }

        $this->registerMiddlewareAlias();
        $this->registerRedirectResponseMacros();
        $this->registerInertiaMacros();
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs/toast.stub' => base_path('stubs/toast.stub'),
        ], 'flash-stubs');

        $this->publishes([
            __DIR__.'/../config/flash.php' => config_path('flash.php'),
        ], 'flash-config');
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
            string|Flashable $message,
            string|FlashType|null $type = null,
            ?int $duration = null,
        ) {
            /** @var RedirectResponse $this */
            Flash::message($message, $type, $duration);

            return $this;
        });
    }

    /**
     * Register the inertia response macros.
     */
    protected function registerInertiaMacros(): void
    {
        ResponseFactory::macro('flash', function (
            string|Flashable $message,
            string|FlashType|null $type = null,
            ?int $duration = null,
        ) {
            /** @var ResponseFactory $this */
            Flash::message($message, $type, $duration);

            return $this;
        });

        Response::macro('flash', function (
            string|Flashable $message,
            string|FlashType|null $type = null,
            ?int $duration = null,
        ) {
            /** @var ResponseFactory $this */
            Flash::message($message, $type, $duration);

            return $this;
        });
    }
}
