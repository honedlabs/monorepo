<?php

declare(strict_types=1);

namespace Honed\Billing;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/billing.php', 'billing');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/billing.php' => config_path('billing.php'),
        ], 'billing-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}