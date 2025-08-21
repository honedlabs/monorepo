<?php

declare(strict_types=1);

namespace Honed\Form;

use Illuminate\Support\ServiceProvider;
use Honed\Form\Commands\FormMakeCommand;
use Honed\Form\Commands\FormComponentMakeCommand;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/form.php', 'form');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                FormMakeCommand::class,
                FormComponentMakeCommand::class
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/form.php' => config_path('form.php'),
        ], 'form-config');

        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'form-stubs');
    }
}