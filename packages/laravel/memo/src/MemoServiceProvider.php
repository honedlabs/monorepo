<?php

declare(strict_types=1);

namespace Honed\Memo;

use Honed\Memo\Contracts\Memoize;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class MemoServiceProvider extends ServiceProvider
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

        $this->app->alias(Memoize::class, 'memo');

        $this->app->bind(Memoize::class, MemoManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Cache::extend('memo', function (Application $app, array $config) {
            return Cache::repository(
                new MemoCacheDecorator(Cache::store($config['store'])),
                ['events' => false]
            );
        });
    }
}
