<?php

namespace Honed\Modal;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class ModalServiceProvider extends ServiceProvider
{
    /**
     * Register any application services for the package.
     * 
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modal.php', 'modal');
    }

    /**
     * Bootstrap the application services for the package.
     * 
     * @return void
     */
    public function boot()
    {
        $this->registerResponseMacros();
        $this->registerTestingMacros();

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
        
    }

    /**
     * Register macros on the Inertia response factory.
     * 
     * @return void
     */
    protected function registerResponseMacros()
    {
        ResponseFactory::macro('modal', function (
            string $component,
            array|Arrayable $props = []
        ) {
            return new Modal($component, $props);
        });

        ResponseFactory::macro('dialog', function (
            string $component,
            array|Arrayable $props = []
        ) {
            return new Modal($component, $props);
        });
    }

    /**
     * Register macros on the TestResponse class.
     * 
     * @return void
     */
    protected function registerTestingMacros()
    {
        // TestResponse::macro('inertiaModal')
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/modal.php' => config_path('modal.php'),
        ], 'modal-config');
    }
}
