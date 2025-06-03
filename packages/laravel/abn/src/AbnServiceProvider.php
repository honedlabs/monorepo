<?php

declare(strict_types=1);

namespace Honed\Abn;

use Honed\Abn\Commands\AbnMakeCommand;
use Illuminate\Support\ServiceProvider;

class AbnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'abn');

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
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
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/abn'),
        ]);
    }
}
