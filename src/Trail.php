<?php

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
     * @var array<int,\Honed\Crumb\Crumb>
     */
    protected $conditional;

    /**
     * Create a new trail instance.
     * 
     * @param array<int,\Honed\Crumb\Crumb> $crumbs
     */
    public function __construct(...$crumbs) 
    {

    }

    public static function make(...$crumbs): static
    {
        return resolve(static::class, ...$crumbs);
    }

    public function toArray(): array
    {
        return $this->crumbs();
    }

    public function select(...$crumbs): static
    {
        return $this;
    }

    public function add(...$crumbs): static
    {
        // dd($crumbs);
        return $this;
    }

    public function root(...$crumbs): static
    {
        return $this;
    }

    public function crumbs(): array
    {
        return $this->crumbs;
    }

    public function share(): void
    {
        Inertia::share(config('crumb.property', 'crumbs'), $this->crumbs());
    }
}
