<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Support\Parameters;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class Manager
{
    /**
     * Keyed navigation groups.
     *
     * @var array<string, array<int,\Honed\Nav\NavGroup>>
     */
    protected $items = [];

    /**
     * Set a navigation group under a given name.
     *
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function for(string $name, array $items): static
    {
        if ($this->hasGroup($name)) {
            static::throwDuplicateGroupException($name);
        }

        Arr::set($this->items, $name, $items);

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
            0 => \array_combine(
                \array_keys($this->items),
                \array_map(
                    fn ($group) => $this->getAllowedItems($group),
                    \array_keys($this->items)
                )
            ),
            1 => $this->getAllowedItems($groups[0]),
            default => \array_combine(
                \array_keys(\array_filter(
                    $this->items,
                    fn ($key) => \in_array($key, $groups),
                    \ARRAY_FILTER_USE_KEY
                )),
                \array_map(
                    fn ($group) => $this->getAllowedItems($group),
                    \array_filter(
                        \array_keys($this->items),
                        fn ($key) => \in_array($key, $groups)
                    )
                )
            ),
        };
    }

    /**
     * Retrieve the navigation group for the given name.
     *
     * @return array<\Honed\Nav\NavGroup>
     */
    public function getGroup(string $group): array
    {
        return Arr::get($this->items, $group);
    }

    /**
     * Share the navigation items with Inertia.
     *
     * @return $this
     */
    public function share(string ...$groups): static
    {
        Inertia::share(Parameters::Prop, $this->get(...$groups));

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
}
