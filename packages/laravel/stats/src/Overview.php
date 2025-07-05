<?php

declare(strict_types=1);

namespace Honed\Stats;

use Closure;
use Inertia\Inertia;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\IgnoreFirstLoad;
use Honed\Stats\Concerns\CanPoll;
use Honed\Stats\Concerns\CanGroup;
use Honed\Stats\Concerns\HasStats;
use Honed\Stats\Concerns\Deferrable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Throwable;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
class Overview extends Primitive
{
    use CanGroup;
    use Deferrable;
    use HasStats;

    public const PROP = 'stats';

    /**
     * The default namespace where overviews reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Overviews\\';

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'overview';

    /**
     * How to resolve the overview for the given model name.
     *
     * @var (Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<Overview>)|null
     */
    protected static $overviewResolver;

    /**
     * Create a new profile instance.
     * 
     * @param  array<int,\Honed\Stats\Stat>|Stat  $stats
     */
    public static function make(array|Stat $stats = []): static
    {
        return resolve(static::class)->stats($stats);
    }

    /**
     * Get a new table instance for the given model name.
     *
     * @template TClass of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TClass>  $modelName
     * @return Overview<TClass>
     */
    public static function overviewForModel(string $modelName): static
    {
        $overview = static::resolveOverview($modelName);

        return $overview::make();
    }

    /**
     * Get the overview name for the given model name.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $className
     * @return class-string<Overview>
     */
    public static function resolveOverview(string $className): string
    {
        $resolver = static::$overviewResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<Overview> */
            return static::$namespace.$className.'Overview';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's model overviews.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model table.
     *
     * @param  Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<Table>  $callback
     */
    public static function guessOverviewNamesUsing(Closure $callback): void
    {
        static::$overviewResolver = $callback;
    }

    /**
     * Flush the global configuration state.
     */
    public static function flushState(): void
    {
        static::$overviewResolver = null;
        static::$namespace = 'App\\Overviews\\';
    }

    /**
     * Get the application namespace for the application.
     */
    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (Throwable) {
            return 'App\\';
        }
    }

    /**
     * Define the profile.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            '_values' => $this->getValues(),
            '_stat_key' => self::PROP,
            ...$this->deferredProps(),
        ];
    }

    /**
     * Get the key of the stats.
     */
    protected function getStatKey(): ?string
    {
        if ($this->isGrouped() && $this->isLazy()) {
            return self::PROP;
        }

        return null;
    }

    /**
     * Get the values of the stats.
     *
     * @return array<int, string>
     */
    protected function getValues(): array
    {
        return array_map(
            static fn (Stat $stat) => [
                $stat->getName(),
                $stat->getLabel(),
            ],
            $this->getStats()
        );
    }

    /**
     * Get the stats.
     *
     * @return array<array-key, \Inertia\IgnoreFirstLoad>
     */
    protected function deferredProps(): array
    {
        $stats = $this->getStats();

        if ($key = $this->getStatKey()) {
            return [
                $key => Inertia::lazy(fn () => Arr::mapWithKeys(
                    $stats,
                    static fn (Stat $stat) => [
                        $stat->getName() => $stat->dataFrom(),
                    ]
                )),
            ];
        }

        return Arr::mapWithKeys(
            $stats,
            fn (Stat $stat) => [
                $stat->getName() => $this->deferredProp($stat),
            ]
        );
    }

    /**
     * Create the deferred prop.
     */
    protected function deferredProp(Stat $stat): IgnoreFirstLoad
    {
        if ($this->isLazy()) {
            return Inertia::lazy(fn () => $stat->dataFrom());
        }

        return Inertia::defer(
            fn () => $stat->dataFrom(),
            $stat->getGroup() ?? 'default'
        );
    }
}
