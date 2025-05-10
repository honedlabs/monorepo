<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Console\Commands\ChartMakeCommand;
use Honed\Chart\Console\Commands\SankeyMakeCommand;
use Honed\Chart\Console\Commands\TimelineMakeCommand;
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
            $this->commands([
                ChartMakeCommand::class,
                TimelineMakeCommand::class,
                SankeyMakeCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/chart.php' => config_path('chart.php'),
            ], 'chart-config');
        }
    }
}