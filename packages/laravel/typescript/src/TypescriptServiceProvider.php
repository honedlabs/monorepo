<?php

declare(strict_types=1);

namespace Honed\Typescript;

use Illuminate\Support\ServiceProvider;

class TypescriptServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/typescript.php', 'typescript');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/typescript.php' => config_path('typescript.php'),
        ], 'typescript-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}