<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Commands\ChartMakeCommand;
use Illuminate\Support\ServiceProvider;

class ChartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/chart.php', 'chart');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ChartMakeCommand::class,
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
        ], 'chart-stubs');

        $this->publishes([
            __DIR__.'/../config/chart.php' => config_path('chart.php'),
        ], 'chart-config');
    }
}