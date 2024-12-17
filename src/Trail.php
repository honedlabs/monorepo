<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Inertia\Inertia;

class Trail extends Primitive
{
    use Concerns\ClosureParameters;

    /**
     * @var array<int,\Honed\Crumb\Crumb|non-empty-array{array<string,mixed>,array<string,mixed>}>
     */
    protected $crumbs;

    /**
     * @var array<int,\Honed\Crumb\Crumb|non-empty-array{array<string,mixed>,array<string,mixed>}>
     */
    protected $optionals;

    /**
     * @var bool
     */
    protected $locking = false;

    /**
     * @var bool
     */
    protected $locked = false;

    /**
     * @var array{array<string,mixed>,array<string,mixed>}
     */
    protected $parameters = [];

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
        match (true) {
            $this->locked => null,
            // $this->locking =>
            default => $this->crumbs[] = match (true) {
                $crumb instanceof Crumb => $crumb,
                default => Crumb::make($crumb, $link, $icon),
            },
        };

        return $this;
    }

    public function oneOf(...$crumbs)
    {
        if (! $this->isLocking()) {
            throw new \Exception('Cannot add crumbs when the trail is not locked.');
        }

        // ->oneOf(Crumb::make('Home', '/', 'home'))
        // ->optional('Home', '/')
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
     * Retrieve the route parameters.
     * 
     * @return non-empty-array{array<string,mixed>,array<string,mixed>}
     */
    private function routeParameters(): array
    {
        return $this->parameters ??= $this->getClosureParameters();
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
