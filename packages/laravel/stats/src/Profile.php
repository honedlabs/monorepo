<?php

declare(strict_types=1);

namespace Honed\Stats;

use Honed\Core\Primitive;
use Honed\Stats\Concerns\CanGroup;
use Honed\Stats\Concerns\CanPoll;
use Honed\Stats\Concerns\Deferrable;
use Honed\Stats\Concerns\HasStats;
use Illuminate\Support\Arr;
use Inertia\IgnoreFirstLoad;
use Inertia\Inertia;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
class Profile extends Primitive
{
    use CanGroup;
    use CanPoll;
    use Deferrable;
    use HasStats;

    public const PROP = 'stats';

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
            static fn (Stat $stat) => $stat->getName(),
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
                        $stat->getName() => $stat->getData(),
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
            return Inertia::lazy(fn () => $stat->getData());
        }

        return Inertia::defer(
            fn () => $stat->getData(),
            $stat->getGroup() ?? 'default'
        );
    }
}
