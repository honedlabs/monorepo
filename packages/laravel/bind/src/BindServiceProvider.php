<?php

declare(strict_types=1);

namespace Honed\Bind;

use Honed\Bind\Commands\BindCacheCommand;
use Honed\Bind\Commands\BindClearCommand;
use Honed\Bind\Commands\BinderMakeCommand;
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
     * @var array<int, string>
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
     */
    public static function addBinderDiscoveryPaths(iterable|string $paths): void
    {
        /** @var array<int, string> $paths */
        $paths = is_string($paths)
            ? [$paths]
            : (is_array($paths) ? $paths : iterator_to_array($paths));

        static::$binderDiscoveryPaths = (new LazyCollection(static::$binderDiscoveryPaths))
            ->merge($paths)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Set the globally configured binder discovery paths.
     *
     * @param  iterable<int, string>  $paths
     */
    public static function setBinderDiscoveryPaths(iterable $paths): void
    {
        static::$binderDiscoveryPaths = is_array($paths)
            ? $paths
            : iterator_to_array($paths);
    }

    /**
     * Get the globally configured binder discovery paths.
     *
     * @return array<int, string>
     */
    public static function getBinderDiscoveryPaths(): array
    {
        return static::$binderDiscoveryPaths;
    }

    /**
     * Disable binder discovery for the application.
     */
    public static function disableBinderDiscovery(bool $disable = true): void
    {
        static::$shouldDiscoverBinders = ! $disable;
    }

    /**
     * Set the base of the discovery path.
     */
    public static function setBinderDiscoveryBasePath(string $path): void
    {
        static::$binderDiscoveryBasePath = $path;
    }

    /**
     * Get the base of the discovery path.
     */
    public static function getBinderDiscoveryBasePath(): ?string
    {
        return static::$binderDiscoveryBasePath;
    }

    /**
     * Register services.
     */
    public function register(): void
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
     */
    public function boot(): void
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
    public function getBinders(): array
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
    public function binders(): array
    {
        return $this->binders;
    }

    /**
     * Determine if binders should be automatically discovered.
     */
    public function shouldDiscoverBinders(): bool
    {
        return get_class($this) === __CLASS__ && static::$shouldDiscoverBinders;
    }

    /**
     * Discover the binders for the application.
     *
     * @return array<int, class-string<Binder>>
     */
    public function discoverBinders(): array
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
    public function discoveredBinders(): array
    {
        return $this->shouldDiscoverBinders()
            ? $this->discoverBinders()
            : [];
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'bind-stubs');
    }

    /**
     * Get the directories that should be used to discover binders.
     *
     * @return array<int, string>
     */
    protected function discoverBindersWithin(): array
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        return static::$binderDiscoveryPaths ?: [
            $app->path('Binders'),
        ];
    }

    /**
     * Get the base path to be used during binder discovery.
     */
    protected function binderDiscoveryBasePath(): string
    {
        return static::$binderDiscoveryBasePath ?? base_path();
    }
}
