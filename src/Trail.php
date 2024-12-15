<?php

namespace Honed\Crumb;

use Inertia\Inertia;

class Trail 
{
    public function __construct(...$crumbs) 
    {

    }

    public static function make(...$crumbs): static
    {
        return resolve(static::class, ...$crumbs);
    }

    public function select(...$crumbs): static
    {

    }

    public function add(...$crumbs): static
    {

    }

    public function crumbs(): array
    {
        return $this->crumbs;
    }

    public function share(): void
    {
        Inertia::share('crumbs', $this->crumbs());
    }
}
