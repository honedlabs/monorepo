<?php

declare(strict_types=1);

namespace Honed\List;

use Honed\Command\Commands\ListMakeCommand;
use Illuminate\Support\ServiceProvider;

class ListServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ListMakeCommand::class,
            ]);
        }
    }
}