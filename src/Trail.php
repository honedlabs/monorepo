<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Inertia\Inertia;
use Honed\Core\Primitive;
use Honed\Crumb\Exceptions\CrumbUnlockedException;

class Trail extends Primitive
{
    /**
     * @var array<int,\Honed\Crumb\Crumb>
     */
    protected $crumbs;

    /**
     * @var bool
     */
    protected $locking = false;

    /**
     * @var bool
     */
    protected $locked = false;

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
     * Set the trail to lock when a crumb in the trail is found.
     */
    public function locking(bool $locking = true): static
    {
        $this->locking = $locking;

        return $this;
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
        if ($this->isNotLocked()) {
            $crumb = $crumb instanceof Crumb ? $crumb : Crumb::make($crumb, $link, $icon);
            $this->crumbs[] = $crumb;
            $this->locked = $this->isLocking() && $crumb->isCurrent();
        }

        return $this;
    }

    public function select(...$crumbs)
    {
        if ($this->isNotLocking()) {
            throw new CrumbUnlockedException();
        }

        $crumb = collect($crumbs)->first(static fn (Crumb $crumb) => $crumb->isCurrent());

        if ($crumb) {
            $this->crumbs[] = $crumb;
            $this->locked = true;
        }

        return $this;
    }

    /**
     * Determine if the trail is locking.
     * 
     * @return bool
     */
    public function isLocking(): bool
    {
        return $this->locking;
    }

    /**
     * Determine if the trail is not locking
     */
    public function isNotLocking(): bool
    {
        return ! $this->isLocking();
    }

    /**
     * Determine if the trail is locked.
     * 
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * Determine if the trail is not locked.
     * 
     * @return bool
     */
    public function isNotLocked(): bool
    {
        return ! $this->isLocked();
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
