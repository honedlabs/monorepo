<?php

declare(strict_types=1);

namespace Honed\Binding;

use Honed\Binding\Commands\BinderMakeCommand;
use Honed\Binding\Commands\BindingCacheCommand;
use Honed\Binding\Commands\BindingClearCommand;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class BindingServiceProvider extends ServiceProvider
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
            ->merge(is_string($paths) ? [$paths] : $paths)
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
        $this->optimizes(BindingCacheCommand::class);

        if ($this->app->runningInConsole()) {

            $this->offerPublishing();

            $this->commands([
                BindingCacheCommand::class,
                BindingClearCommand::class,
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
        return get_class($this) === __CLASS__ && static::$shouldDiscoverBinders;
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
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        // $this->publishes([
        //     __DIR__.'/../config/binding.php' => $this->app->configPath('binding.php'),
        // ], 'binding-config');
    }

    /**
     * Get the discovered binders for the application.
     *
     * @return array
     */
    protected function discoveredBinders()
    {
        return $this->shouldDiscoverBinders()
            ? $this->discoverBinders()
            : [];
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
