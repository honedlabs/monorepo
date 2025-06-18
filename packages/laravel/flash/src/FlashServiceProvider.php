<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Contracts\Message as MessageContract;
use Honed\Flash\Facades\Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\ResponseFactory;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flash.php', 'flash');

        /** @var class-string<MessageContract> */
        $implementation = config('flash.implementation', Message::class);

        $this->app->bind(MessageContract::class, $implementation);
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
            $this->publishes([
                __DIR__.'/../config/flash.php' => config_path('flash.php'),
            ], 'config');
        }

        $this->registerMiddlewareAlias();
        $this->registerRedirectResponseMacros();
        $this->registerInertiaMacros();
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/flash.php' => config_path('flash.php'),
            ], 'config');
        }
    }

    /**
     * Register the middleware alias for flash messages.
     *
     * @return void
     */
    protected function registerMiddlewareAlias()
    {
        Route::aliasMiddleware('flash', Middleware\ShareFlash::class);
    }

    /**
     * Register the redirect response macros.
     *
     * @return void
     */
    protected function registerRedirectResponseMacros()
    {
        RedirectResponse::macro('flash', function (
            string|MessageContract $message,
            ?string $type = null,
            ?int $duration = null,
        ) {
            /** @var RedirectResponse $this */
            Flash::message($message, $type, $duration);

            return $this;
        });
    }

    /**
     * Register the inertia response macros.
     *
     * @return void
     */
    protected function registerInertiaMacros()
    {
        ResponseFactory::macro('flash', function (
            string|MessageContract $message,
            ?string $type = null,
            ?int $duration = null,
        ) {
            /** @var ResponseFactory $this */
            Flash::message($message, $type, $duration);

            return $this;
        });

        Response::macro('flash', function (
            string|MessageContract $message,
            ?string $type = null,
            ?int $duration = null,
        ) {
            /** @var ResponseFactory $this */
            Flash::message($message, $type, $duration);

            return $this;
        });
    }
}
