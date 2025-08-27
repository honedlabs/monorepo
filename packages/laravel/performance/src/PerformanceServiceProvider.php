<?php

declare(strict_types=1);

namespace Honed\Performance;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PerformanceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GateContract::class, function (Container $app) {
            return new Gate($app, function () use ($app) {
                return call_user_func($app->make('auth')->userResolver());
            });
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, class-string>
     */
    public function provides(): array
    {
        return [
            GateContract::class,
        ];
    }
}
