<?php

declare(strict_types=1);

namespace Honed\Stat;

use Honed\Core\Primitive;
use Honed\Stat\Concerns\CanGroup;
use Honed\Stat\Concerns\CanPoll;
use Honed\Stat\Concerns\Deferrable;
use Honed\Stat\Concerns\HasStats;
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
     * @return array<string,mixed>
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
     * @return array<array-key, Inertia\IgnoreFirstLoad>
     */
    protected function deferredProps()
    {
        $stats = $this->getStats();

        if ($key = $this->getStatKey()) {
            return [
                $key => Inertia::lazy(
                    Arr::mapWithKeys(
                        $stats,
                        static fn (Stat $stat) => [
                            $stat->getName() => $stat->getData(),
                        ]
                    )
                ),
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
            return Inertia::lazy($stat->getData(...));
        }

        return Inertia::defer(
            $stat->getData(...),
            $stat->getGroup() ?? 'default'
        );
    }
}
