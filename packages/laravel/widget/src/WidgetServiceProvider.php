<?php

declare(strict_types=1);

namespace Honed\Widget;

use Illuminate\Support\ServiceProvider;
use Honed\Widget\Commands\WidgetCacheCommand;
use Honed\Widget\Commands\WidgetMakeCommand;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WidgetManager::class, fn ($app) => new WidgetManager($app));

        $this->mergeConfigFrom(__DIR__.'/../config/widget.php', 'widget');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->optimizes(WidgetCacheCommand::class);

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                WidgetMakeCommand::class,
            ]);
        }

        // $this->listenForEvents();
    }

    /**
     * Register the migrations and publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/widget.php' => config_path('widget.php'),
        ], 'widget-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
        ], 'widget-migrations');
    }
}