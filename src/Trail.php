<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Honed\Crumb\Exceptions\CrumbUnlockedException;
use Inertia\Inertia;

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
     */
    public function __construct(Crumb ...$crumbs)
    {
        $this->crumbs = \array_values($crumbs);
    }

    /**
     * Make a new trail instance.
     */
    public static function make(Crumb ...$crumbs): self
    {
        return new self(...$crumbs);
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
     * @param  string|\Honed\Crumb\Crumb|(\Closure(mixed...):string)  $crumb
     * @param  string|(\Closure(mixed...):string)|null  $link
     * @return $this
     */
    public function add(string|\Closure|Crumb $crumb, string|\Closure|null $link = null, ?string $icon = null): static
    {
        if ($this->isNotLocked()) {
            $crumb = $crumb instanceof Crumb ? $crumb : Crumb::make($crumb, $link, $icon);
            $this->crumbs[] = $crumb;
            $this->locked = $this->isLocking() && $crumb->isCurrent();
        }

        return $this;
    }

    /**
     * Select and add the first matching crumb to the trail.
     *
     * @return $this
     *
     * @throws CrumbUnlockedException
     */
    public function select(Crumb ...$crumbs): static
    {
        if ($this->isLocked()) {
            return $this;
        }

        if ($this->isNotLocking()) {
            throw new CrumbUnlockedException;
        }

        $crumb = collect($crumbs)->first(fn (Crumb $crumb): bool => $crumb->isCurrent());

        if ($crumb) {
            $this->crumbs[] = $crumb;
            $this->locked = true;
        }

        return $this;
    }

    /**
     * Determine if the trail is locking.
     *
     * @internal
     */
    public function isLocking(): bool
    {
        return $this->locking;
    }

    /**
     * Determine if the trail is not locking
     *
     * @internal
     */
    public function isNotLocking(): bool
    {
        return ! $this->isLocking();
    }

    /**
     * Determine if the trail is locked.
     *
     * @internal
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * Determine if the trail is not locked.
     *
     * @internal
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
        return \count($this->crumbs()) > 0;
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
