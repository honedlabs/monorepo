<?php

declare(strict_types=1);

namespace Honed\Infolist;

use Honed\Infolist\Commands\InfolistMakeCommand;
use Illuminate\Support\ServiceProvider;

class InfolistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InfolistMakeCommand::class,
            ]);
        }
    }
}
