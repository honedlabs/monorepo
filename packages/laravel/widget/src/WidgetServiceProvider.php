<?php

declare(strict_types=1);

namespace Honed\Widget;

use Honed\Widget\Commands\WidgetMakeCommand;
use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/widget.php', 'widget');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/widget.php' => config_path('widget.php'),
        ], 'widget-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                WidgetMakeCommand::class,
            ]);
        }
    }
}