<?php

declare(strict_types=1);

namespace Honed\Bind;

use Honed\Bind\Commands\BinderMakeCommand;
use Honed\Bind\Commands\BindCacheCommand;
use Honed\Bind\Commands\BindClearCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * The binders to manually register.
     *
     * @var array<string, class-string<Binder>>
     */
    protected $binders = [];

    /**
     * Indicates if the package should discover binders.
     *
     * @var bool
     */
    protected static $shouldDiscoverBinders = true;

    /**
     * The paths to discover binders.
     *
     * @var iterable<int, string>|null
     */
    protected static $binderDiscoveryPaths;

    /**
     * Add the given widget discovery paths to the application's widget discovery paths.
     *
     * @param  string|iterable<int, string>  $paths
     * @return void
     */
    public static function addBinderDiscoveryPaths(iterable|string $paths)
    {
        static::$binderDiscoveryPaths = (new LazyCollection(static::$binderDiscoveryPaths))
            ->merge(Arr::wrap($paths))
            ->unique()
            ->values();
    }

    /**
     * Set the globally configured binder discovery paths.
     *
     * @param  iterable<int, string>  $paths
     * @return void
     */
    public static function setBinderDiscoveryPaths($paths)
    {
        static::$binderDiscoveryPaths = $paths;
    }

    /**
     * Disable binder discovery for the application.
     *
     * @return void
     */
    public static function disableBinderDiscovery()
    {
        static::$shouldDiscoverBinders = false;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::macro('getCachedBindersPath', function () {
            /** @var \Illuminate\Foundation\Application $this */
            return $this->normalizeCachePath('APP_BINDERS_CACHE', 'cache/binders.php');
        });

        App::macro('bindersAreCached', function () {
            /** @var \Illuminate\Foundation\Application $this */
            return $this->files->exists($this->getCachedBindersPath());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->optimizes(BindCacheCommand::class);

        if ($this->app->runningInConsole()) {

            $this->offerPublishing();

            $this->commands([
                BindCacheCommand::class,
                BindClearCommand::class,
                BinderMakeCommand::class,
            ]);
        }
    }

    /**
     * Get the discovered binders for the application.
     *
     * @return array
     */
    public function getBinders()
    {
        if ($this->app->bindersAreCached()) {
            $cache = require $this->app->getCachedBindersPath();

            return $cache[get_class($this)] ?? [];
        }

        return array_merge_recursive(
            $this->discoveredBinders(),
            $this->binders()
        );

    }

    /**
     * Get the binders that should be cached.
     *
     * @return array<int, class-string<Binder>>
     */
    public function binders()
    {
        return $this->binders;
    }

    /**
     * Determine if binders should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverBinders()
    {
        return static::$shouldDiscoverBinders;
    }

    /**
     * Discover the binders for the application.
     *
     * @return array
     */
    public function discoverBinders()
    {
        return (new LazyCollection($this->discoverBindersWithin()))
            ->flatMap(function ($directory) {
                return glob($directory, GLOB_ONLYDIR);
            })
            ->reject(function ($directory) {
                return ! is_dir($directory);
            })
            ->pipe(fn ($directories) => DiscoverBinders::within(
                $directories->all(),
                $this->binderDiscoveryBasePath(),
            ));
    }

    /**
     * Get the discovered binders for the application.
     *
     * @return array<int, class-string<Binder>>
     */
    public function discoveredBinders()
    {
        return $this->shouldDiscoverBinders()
            ? $this->discoverBinders()
            : [];
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'action-stubs');
    }

    /**
     * Get the directories that should be used to discover binders.
     *
     * @return iterable<int, string>
     */
    protected function discoverBindersWithin()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        return static::$binderDiscoveryPaths ?: [
            $app->path('Binders'),
        ];
    }

    /**
     * Get the base path to be used during binder discovery.
     *
     * @return string
     */
    protected function binderDiscoveryBasePath()
    {
        return base_path();
    }
}
