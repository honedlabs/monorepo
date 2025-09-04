<?php

declare(strict_types=1);

namespace Honed\Disable;

use Honed\Disable\Support\Disable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class DisableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/disable.php', 'disable');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/disable.php' => config_path('disable.php'),
        ], 'disable-config');

        /**
         * Add the disableable fields to the table.
         */
        Blueprint::macro('disableable', function (string $users = 'users'): void {
            /** @var Blueprint $this */
            if (Disable::boolean()) {
                $this->boolean('is_disabled')->default(false);
            }

            if (Disable::timestamp()) {
                $this->timestamp('disabled_at')->nullable();
            }

            if (Disable::user()) {
                $this->foreignId('disabled_by')->nullable()->constrained($users);
            }
        });
    }
}
