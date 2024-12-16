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
        $this->add(...$crumbs);
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
     * @param array<int,\Honed\Crumb\Crumb|array{string|\Closure,string|\Closure|null,string|null}> $crumbs
     * @return $this
     */
    public function add(...$crumbs): static
    {
        foreach ($crumbs as $crumb) {
            $this->addCrumb(...$crumb);
        }

        return $this;
    }

    /**
     * Add a single crumb to the trail.
     * 
     * @param \Honed\Crumb\Crumb|string $crumb
     * @param string|null $link
     * @param string|null $icon
     */
    private function addCrumb(Crumb|string $crumb, string $link = null, string $icon = null): void
    {
        match (true) {
            $crumb instanceof Crumb => $this->crumbs[] = $crumb,
            default => $this->crumbs[] = Crumb::make($crumb, $link, $icon),
        };
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
     */
    public function share(): void
    {
        Inertia::share('crumbs', $this->crumbs());
    }
}
