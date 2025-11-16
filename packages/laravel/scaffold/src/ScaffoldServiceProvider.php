<?php

declare(strict_types=1);

namespace Honed\Scaffold;

use Honed\Scaffold\Commands\ScaffoldCommand;
use Honed\Scaffold\Commands\ScaffolderMakeCommand;
use Honed\Scaffold\Contracts\ScaffoldContext as ScaffoldContextContract;
use Honed\Scaffold\Support\ScaffoldContext;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/scaffold.php', 'scaffold');

        /** @var class-string<ScaffoldContextContract> */
        $context = config('scaffold.context', ScaffoldContext::class);

        $this->app->bind(ScaffoldContextContract::class, $context);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/scaffold.php' => config_path('scaffold.php'),
        ], 'scaffold-config');

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ScaffoldCommand::class,
                ScaffolderMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/scaffold.php' => config_path('scaffold.php'),
        ], 'scaffold-config');

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'scaffold-stubs');
    }
}
