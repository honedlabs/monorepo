<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Table\Commands\ColumnMakeCommand;
use Honed\Table\Commands\PurgeCommand;
use Honed\Table\Commands\TableMakeCommand;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/table.php', 'table');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ColumnMakeCommand::class,
                PurgeCommand::class,
                TableMakeCommand::class,
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
        ], 'table-stubs');

        $this->publishes([
            __DIR__.'/../config/table.php' => config_path('table.php'),
        ], 'table-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'table-migrations');
    }
}
