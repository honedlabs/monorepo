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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/flash.php' => config_path('flash.php'),
            ], 'config');
        }

        $this->registerRedirectResponseMacros();
    }

    /**
     * Register the redirect response macros.
     */
    protected function registerRedirectResponseMacros(): void
    {
        RedirectResponse::macro('flash', function () {
            /** @var \Illuminate\Http\RedirectResponse $this */

            return $this->with(
                'flash',
                $this->session->get('flash')
            );
        });
    }
    
}