<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Commands\PipeMakeCommand;
use Honed\Core\Contracts\ScopedPrimitiveManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register the bindings.
     */
    public function register(): void
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
     */
    public function boot(): void
    {
        $this->registerMacros();

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                PipeMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    public function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'core-stubs');
    }

    /**
     * Register the macros for the package.
     */
    public function registerMacros(): void
    {
        Str::macro('label', function (string $value): string {
            return Str::of($value)
                ->afterLast('.')
                ->headline()
                ->lower()
                ->ucfirst()
                ->toString();
        });
    }
}
