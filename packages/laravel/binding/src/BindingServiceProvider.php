<?php

declare(strict_types=1);

namespace Honed\Binding;

use Honed\Binding\Commands\BinderMakeCommand;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            // $this->offerPublishing();

            $this->commands([
                BinderMakeCommand::class,
            ]);
        }
    }
}
