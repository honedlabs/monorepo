<?php

declare(strict_types=1);

namespace Honed\Modal;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Inertia\ResponseFactory;

class ModalServiceProvider extends ServiceProvider
{
    /**
     * Register any application services for the package.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modal.php', 'modal');
    }

    /**
     * Bootstrap the application services for the package.
     */
    public function boot(): void
    {
        $this->configureMacros();

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register macros on the Inertia response factory.
     */
    protected function configureMacros(): void
    {
        ResponseFactory::macro('modal', function (string $component, array $props = []): Modal {
            return new Modal($component, $props);
        });

        ResponseFactory::macro('dialog', function (string $component, array $props = []): Modal {
            return new Modal($component, $props);
        });

        Router::macro('setCurrentRequest', function (Request $request): void {
            /** @var Router $this */
            $this->currentRequest = $request; // @phpstan-ignore-line property.protected
        });
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/modal.php' => config_path('modal.php'),
        ], 'modal-config');
    }
}
