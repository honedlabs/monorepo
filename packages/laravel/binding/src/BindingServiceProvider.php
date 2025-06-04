<?php

declare(strict_types=1);

namespace Honed\Binding;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;
use Honed\Binding\Commands\BinderMakeCommand;
use Honed\Binding\Commands\BindingCacheCommand;
use Honed\Binding\Commands\BindingClearCommand;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * The binders to manually register.
     * 
     * @var array<string, class-string<\Honed\Binding\Binder>>
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
     * Register services.
     */
    public function register(): void {}

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
     * 
     */
    public function getCachedBindersPath()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        return $app->normalizeCachePath('cache/binders.php');
    }

    /**
     * 
     */
    public function bindersAreCached()
    {
        return $this->app->files->exists($this->getCachedBindersPath());
    }

    /**
     * Get the discovered binders for the application.
     *
     * @return array
     */
    public function getBinders()
    {
        if ($this->bindersAreCached()) {
            $cache = require $this->getCachedBindersPath();

            return $cache[get_class($this)] ?? [];
        } else {
            return array_merge_recursive(
                $this->discoveredBinders(),
                $this->binders()
            );
        }
    }

    /**
     * Get the binders that should be cached.
     *
     * @return array<int, class-string<\Honed\Binding\Binder>>
     */
    public function binders()
    {
        return $this->binders;
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
     * Get the base path to be used during binder discovery.
     *
     * @return string
     */
    protected function binderDiscoveryBasePath()
    {
        return base_path();
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
}
