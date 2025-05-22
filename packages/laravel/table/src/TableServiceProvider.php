<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Table\Commands\ColumnMakeCommand;
use Honed\Table\Commands\TableMakeCommand;
use Honed\Table\Contracts\TableExporter;
use Honed\Table\Http\Controllers\TableController;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services
     * 
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/table.php', 'table');

        /** @var string */
        $exporter = config('table.exporter');

        $this->app->bind(TableExporter::class, $exporter);
    }

    /**
     * Bootstrap the application services.
     * 
     * @return void
     */
    public function boot()
    {
        $this->register();

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                TableMakeCommand::class,
                ColumnMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'stubs');

        $this->publishes([
            __DIR__.'/../config/table.php' => config_path('table.php'),
        ], 'config');
    }

    /**
     * Register the macros for the package.
     *
     * @return void
     */
    protected function registerMacros()
    {
        Router::macro('table', function () {
            /** @var \Illuminate\Routing\Router $this */

            /** @var string $endpoint */
            $endpoint = config('table.endpoint', '/table');

            $endpoint = \trim($endpoint, '/');

            $methods = ['post', 'patch', 'put'];

            $this->match($methods, $endpoint, [TableController::class, 'dispatch'])
                ->name('table');

            $this->match($methods, $endpoint.'/{table}', [TableController::class, 'invoke'])
                ->name('table.invoke');
        });
    }
}
