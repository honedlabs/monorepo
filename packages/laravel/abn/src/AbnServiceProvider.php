<?php

declare(strict_types=1);

namespace Honed\Abn;

use Honed\Abn\Rules\Abn;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;

class AbnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Rule::macro('abn', function () {
            return new Abn();
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
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
