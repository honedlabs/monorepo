<?php

declare(strict_types=1);

namespace Honed\Stat;

use Honed\Stat\Commands\ProfileMakeCommand;
use Honed\Stat\Commands\StatMakeCommand;
use Illuminate\Support\ServiceProvider;

class StatsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                StatMakeCommand::class,
                ProfileMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'stat-stubs');
    }
}
