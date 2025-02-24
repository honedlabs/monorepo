<?php

declare(strict_types=1);

namespace Honed\Command;

use Honed\Command\Console\Commands\BuilderMakeCommand;
use Honed\Command\Console\Commands\ConcernMakeCommand;
use Honed\Command\Console\Commands\ContractMakeCommand;
use Illuminate\Support\ServiceProvider;

final class CommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BuilderMakeCommand::class,
                ConcernMakeCommand::class,
                ContractMakeCommand::class,
            ]);
        }
    }
}
