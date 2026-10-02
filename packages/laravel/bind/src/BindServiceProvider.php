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
     * @var list<class-string<Binder>>
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
     * @var list<string>
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
        /** @var list<string> $paths */
        $paths = array_values(is_string($paths)
            ? [$paths]
            : (is_array($paths) ? $paths : iterator_to_array($paths)));

        /** @var list<string> $discoveryPaths */
        $discoveryPaths = array_values(
            (new LazyCollection(static::$binderDiscoveryPaths))
                ->merge($paths)
                ->unique()
                ->values()
                ->all()
        );

        static::$binderDiscoveryPaths = $discoveryPaths;
    }

    /**
     * Set the globally configured binder discovery paths.
     *
     * @param  iterable<int, string>  $paths
     */
    public static function setBinderDiscoveryPaths(iterable $paths): void
    {
        /** @var list<string> $discoveryPaths */
        $discoveryPaths = array_values(is_array($paths) ? $paths : iterator_to_array($paths));

        static::$binderDiscoveryPaths = $discoveryPaths;
    }

    /**
     * Get the globally configured binder discovery paths.
     *
     * @return list<string>
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
     * @return list<class-string<Binder>>
     */
    public function getBinders(): array
    {
        /** @var list<class-string<Binder>> $binders */
        $binders = array_values(array_unique(array_merge(
            $this->discoveredBinders(),
            $this->binders(),
        )));

        return $binders;
    }

    /**
     * Get the binders that should be cached.
     *
     * @return list<class-string<Binder>>
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
     * @return list<class-string<Binder>>
     */
    public function discoverBinders(): array
    {
        $binders = (new LazyCollection($this->discoverBindersWithin()))
            ->flatMap(function ($directory) {
                return glob($directory, GLOB_ONLYDIR) ?: [];
            })
            ->reject(function ($directory) {
                return ! is_dir($directory);
            })
            ->pipe(function ($directories) {
                /** @var list<string> $paths */
                $paths = array_values($directories->all());

                return DiscoverBinders::within(
                    $paths,
                    $this->binderDiscoveryBasePath(),
                );
            });

        return $binders;
    }

    /**
     * Get the discovered binders for the application.
     *
     * @return list<class-string<Binder>>
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
     * @return list<string>
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
