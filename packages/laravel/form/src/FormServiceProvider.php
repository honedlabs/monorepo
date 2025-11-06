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
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            if (! $this->app->environment('production')) {
                $this->commands([
                    FormComponentMakeCommand::class,
                    FormListCommand::class,
                    FormMakeCommand::class,
                ]);
            }
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'honed-form-stubs');
    }
}
