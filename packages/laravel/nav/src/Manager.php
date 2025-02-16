<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Support\Parameters;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class Manager
{
    /**
     * Keyed navigation groups.
     *
     * @var array<string, array<int,\Honed\Nav\NavBase>>
     */
    protected $items = [];

    /**
     * Set a navigation group under a given name.
     *
     * @param  iterable<\Honed\Nav\NavBase>  $items
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function for(string $name, iterable $items): static
    {
        if ($this->hasGroup($name)) {
            static::throwDuplicateGroupException($name);
        }

        if ($items instanceof Arrayable) {
            $items = $items->toArray();
        }

        /** @var array<int,\Honed\Nav\NavBase> $items */
        Arr::set($this->items, $name, $items);

        return $this;
    }

    /**
     * Add navigation items to an existing group.
     *
     * @param  iterable<\Honed\Nav\NavBase>  $items
     * @return $this
     */
    public function add(string $name, iterable $items): static
    {
        if (! $this->hasGroup($name)) {
            static::throwMissingGroupException($name);
        }

        if ($items instanceof Arrayable) {
            $items = $items->toArray();
        }

        /** @var array<int,\Honed\Nav\NavBase> $current */
        $current = Arr::get($this->items, $name);

        /** @var array<int,\Honed\Nav\NavBase> $items */
        $updated = \array_merge($current, $items);

        Arr::set($this->items, $name, $updated);

        return $this;
    }

    /**
     * Determine if the group exists.
     */
    public function hasGroup(string $name): bool
    {
        return Arr::has($this->items, $name);
    }

    /**
     * Retrieve the navigation item and groups associated with the provided group(s).
     *
     * @return array<int|string,mixed>
     */
    public function get(string ...$groups): array
    {
        return match (\count($groups)) {
            0 => $this->items,
            1 => $this->getGroup($groups[0]),
            default => Arr::only($this->items, $groups),
        };
    }

    /**
     * Retrieve the navigation group for the given name.
     *
     * @return array<int,\Honed\Nav\NavBase>
     */
    public function getGroup(string $group): array
    {
        /** @var array<int,\Honed\Nav\NavBase> */
        return Arr::get($this->items, $group);
    }

    /**
     * Share the navigation items with Inertia.
     *
     * @return $this
     */
    public function share(string ...$groups): static
    {
        $groups = $this->get(...$groups);

        // Need to map each group to an array for serialization
        $groups = \array_map(
            fn (array $group) => \array_map(
                fn (NavBase $item) => $item->toArray(),
                $group
            ),
            $groups
        );

        Inertia::share(Parameters::Prop, $groups);

        return $this;
    }

    /**
     * Throw an exception for a duplicate group.
     */
    protected static function throwDuplicateGroupException(string $group): never
    {
        throw new \InvalidArgumentException(
            \sprintf('There already exists a group with the name [%s].',
                $group
            ));
    }

    /**
     * Throw an exception for a missing group.
     */
    protected static function throwMissingGroupException(string $group): never
    {
        throw new \InvalidArgumentException(
            \sprintf('There is no group with the name [%s].',
                $group
            ));
    }
}
