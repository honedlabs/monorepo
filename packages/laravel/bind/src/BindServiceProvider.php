<?php

declare(strict_types=1);

namespace Honed\Bind;

use Honed\Bind\Commands\BindCacheCommand;
use Honed\Bind\Commands\BindClearCommand;
use Honed\Bind\Commands\BinderMakeCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * The binders to manually register.
     *
     * @var array<int, class-string<Binder>>
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
     * @var iterable<int, string>
     */
    protected static $binderDiscoveryPaths = [];

    /**
     * The base path to discover binders.
     *
     * @var string|null
     */
    protected static $binderDiscoveryBasePath;

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
            ->values()
            ->all();
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
     * Get the globally configured binder discovery paths.
     *
     * @return iterable<int, string>
     */
    public static function getBinderDiscoveryPaths()
    {
        return static::$binderDiscoveryPaths;
    }

    /**
     * Disable binder discovery for the application.
     *
     * @param  bool  $disable
     * @return void
     */
    public static function disableBinderDiscovery($disable = true)
    {
        static::$shouldDiscoverBinders = ! $disable;
    }

    /**
     * Set the base of the discovery path.
     *
     * @param  string  $path
     * @return void
     */
    public static function setBinderDiscoveryBasePath($path)
    {
        static::$binderDiscoveryBasePath = $path;
    }

    /**
     * Get the base of the discovery path.
     *
     * @return string|null
     */
    public static function getBinderDiscoveryBasePath()
    {
        return static::$binderDiscoveryBasePath;
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

            // @phpstan-ignore-next-line
            return $this->normalizeCachePath(
                'APP_BINDERS_CACHE',
                'cache/binders.php'
            );
        });

        App::macro('bindersAreCached', function () {
            /** @var \Illuminate\Foundation\Application $this */

            // @phpstan-ignore-next-line
            return $this->files->exists($this->getCachedBindersPath());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->offerPublishing();

            // @phpstan-ignore-next-line function.alreadyNarrowedType
            if (method_exists($this, 'optimizes')) {
                $this->optimizes('bind:cache', key: 'binders');
            }

            $this->commands([
                BindCacheCommand::class,
                BindClearCommand::class,
                BinderMakeCommand::class,
            ]);
        }
    }

    /**
     * Get the binders which can be registered.
     *
     * @return array<int, class-string<Binder>>
     */
    public function getBinders()
    {
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
     * @return array<int, class-string<Binder>>
     */
    public function discoverBinders()
    {
        return (new LazyCollection($this->discoverBindersWithin()))
            ->flatMap(function ($directory) { // @phpstan-ignore argument.type
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
        ], 'bind-stubs');
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
        return static::$binderDiscoveryBasePath ?? base_path();
    }
}
