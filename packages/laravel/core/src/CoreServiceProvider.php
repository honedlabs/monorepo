<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Support\ServiceProvider;
use Honed\Core\Commands\PipeMakeCommand;
use Honed\Core\Contracts\ScopedPrimitiveManager;

final class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register the bindings.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->scoped(
            ScopedPrimitiveManager::class,
            fn () => $this->app->make(PrimitiveManager::class)->clone(),
        );
        $this->app->booted(fn () => PrimitiveManager::resolveScoped());
        // class_exists(RequestReceived::class) && Event::listen(RequestReceived::class, fn () => PrimitiveManager::resolveScoped());
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

            $this->commands([
                PipeMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    public function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'core-stubs');
    }
}
