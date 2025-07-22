<?php

declare(strict_types=1);

namespace Honed\Billing;

use Honed\Billing\Commands\ListProductsCommand;
use Honed\Billing\Commands\ValidateSchemaCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/billing.php', 'billing'
        );

        $this->app->singleton(BillingManager::class);

        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ListProductsCommand::class,
                ValidateSchemaCommand::class,
            ]);
        }
    }

    /**
     * Register the middleware aliases.
     */
    protected function registerMiddleware(): void
    {
        // Route::aliasMiddleware('billing.subscribed', Subscribed::class);
        // Route::aliasMiddleware('billing.not.subscribed', NotSubscribed::class);
        // Route::aliasMiddleware('billing.subscribed.redirect', SubscribedRedirect::class);
        // Route::aliasMiddleware('billing.cancelled', Product::class);
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/billing.php' => config_path('billing.php'),
        ], 'billing-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'billing-migrations');
    }
}
