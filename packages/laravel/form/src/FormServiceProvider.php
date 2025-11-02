<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Commands\FormComponentMakeCommand;
use Honed\Form\Commands\FormListCommand;
use Honed\Form\Commands\FormMakeCommand;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/honed-form.php', 'honed-form');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                FormComponentMakeCommand::class,
                FormListCommand::class,
                FormMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/honed-form.php' => config_path('honed-form.php'),
        ], 'honed-form-config');

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'honed-form-stubs');
    }
}
