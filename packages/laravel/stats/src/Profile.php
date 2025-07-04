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
    public const PROP = 'stats';

    use CanPoll;
    use CanGroup;
    use Deferrable;

    /**
     * The stats.
     * 
     * @var array<int,\Honed\Stat\Stat>
     */
    protected $stats = [];

    /**
     * Create a new profile instance.
     */
    public static function make(array|Stat $stats = []): static
    {
        return resolve(static::class)->stats($stats);
    }

    /**
     * Get the stats.
     *
     * @param array<int,\Honed\Stats\Stat> $stats
     * @return $this
     */
    public function stats(array|Stat $stats): static
    {
        /** @var array<int,\Honed\Stat\Stat> */
        $stats = is_array($stats) ? $stats : func_get_args();

        $this->stats = [...$this->stats, ...$stats];

        return $this;
    }

    /**
     * Get the stats for serialization.
     * 
     * @return array<int,\Honed\Stat\Stat>
     */
    public function getStats(): array
    {
        return $this->stats;
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
                            $stat->getName() => $stat->getData()
                        ]
                    )
                )
            ];
        }

        return Arr::mapWithKeys(
            $stats,
            fn (Stat $stat) => [
                $stat->getName() => $this->deferredProp($stat)
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