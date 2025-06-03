<?php

declare(strict_types=1);

namespace Honed\Binding;

use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/binding.php', 'binding');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/binding.php' => config_path('binding.php'),
        ], 'binding-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}