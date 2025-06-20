<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Commands\PipeMakeCommand;
use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
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
