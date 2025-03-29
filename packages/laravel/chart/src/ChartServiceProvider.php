<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Console\Commands\ChartMakeCommand;
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
        $this->publishes([
            __DIR__.'/../config/chart.php' => config_path('chart.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ChartMakeCommand::class,
            ]);
        }
    }
}