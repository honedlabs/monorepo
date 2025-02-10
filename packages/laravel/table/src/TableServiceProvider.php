<?php

namespace Honed\Table;

use Honed\Table\Console\Commands\TableMakeCommand;
use Honed\Table\Http\InvokedController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/table.php', 'table');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TableMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'honed-stubs');

        $this->publishes([
            __DIR__.'/../config/table.php' => config_path('table.php'),
        ], 'table-config');

        $this->configureEndpoint();
    }

    /**
     * @return array<int,class-string>
     */
    public function provides(): array
    {
        return [
            TableMakeCommand::class,
        ];
    }

    /**
     * Configure the default endpoint for the Table class.
     */
    private function configureEndpoint(): void
    {
        Route::macro('table', function () {
            Route::post(Table::getDefaultEndpoint(), InvokedController::class);
        });
    }
}
