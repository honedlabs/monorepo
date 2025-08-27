<?php

declare(strict_types=1);

namespace Honed\Memo;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MemoServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GateContract::class, function (Container $app) {
            return new MemoGate($app, function () use ($app) {
                return call_user_func($app->make('auth')->userResolver());
            });
        });

        $this->app->bind('cache', CacheManager::class);

        $this->app->bind('memo', MemoManager::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            GateContract::class,
            'cache',
            'memo',
        ];
    }
}
