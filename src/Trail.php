<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Inertia\Inertia;

class Trail extends Primitive
{
    /**
     * @var array<int,\Honed\Crumb\Crumb>
     */
    protected $crumbs;

    /**
     * Create a new trail instance.
     * 
     * @param array<int,\Honed\Crumb\Crumb> $crumbs
     */
    public function __construct(...$crumbs) 
    {
        $this->crumbs = $crumbs;
    }

    /**
     * Make a new trail instance.
     * 
     * @param array<int,\Honed\Crumb\Crumb> $crumbs
     * @return $this
     */
    public static function make(...$crumbs): static
    {
        return new static(...$crumbs);
    }

    /**
     * Get the trail as an array.
     * 
     * @return array<int,\Honed\Crumb\Crumb>
     */
    public function toArray(): array
    {
        return $this->crumbs();
    }

    /**
     * Append crumbs to the end of the crumb trail.
     * 
     * @param string|\Honed\Crumb\Crumb|(\Closure(mixed...):string) $crumb
     * @param string|(\Closure(mixed...):string)|null $link
     * @param string|null $icon
     * @return $this
     */
    public function add(string|\Closure|Crumb $crumb, string|\Closure|null $link = null, string|null $icon = null): static
    {
        $this->crumbs[] = match (true) {
            $crumb instanceof Crumb => $crumb,
            default => Crumb::make($crumb, $link, $icon),
        };

        return $this;
    }

    /**
     * Retrieve the crumbs in the crumb trail.
     * 
     * @return array<int,\Honed\Crumb\Crumb>
     */
    public function crumbs(): array
    {
        return $this->crumbs;
    }

    /**
     * Determine if the crumb trail has crumbs.
     */
    public function hasCrumbs(): bool
    {
        return \sizeof($this->crumbs()) > 0;
    }

    /**
     * Determine if the crumb trail is missing crumbs.
     */
    public function missingCrumbs(): bool
    {
        return ! $this->hasCrumbs();
    }

    /**
     * Share the crumbs with Inertia.
     * 
     * @return $this
     */
    public function share(): static
    {
        Inertia::share('crumbs', $this->crumbs());

        return $this;
    }
}
