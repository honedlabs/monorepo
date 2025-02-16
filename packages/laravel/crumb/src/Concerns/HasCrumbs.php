<?php

declare(strict_types=1);

namespace Honed\Crumb\Concerns;

use Honed\Crumb\Crumb;

trait HasCrumbs
{
    /**
     * List of the crumbs.
     * 
     * @var array<string,\Honed\Crumb\Trail>
     */
    protected $crumbs = [];

    /**
     * Retrieve the crumbs
     * 
     * @return array<string,\Honed\Crumb\Trail>
     */
    public function getCrumbs(): array
    {
        return $this->crumbs;
    }

    /**
     * Determine if the instance has crumbs.
     */
    public function hasCrumbs(): bool
    {
        return filled($this->getCrumbs());
    }

    /**
     * Get the crumbs as an array.
     * 
     * @return array<int,mixed>
     */
    public function crumbsToArray(): array
    {
        return \array_map(
            static fn (Crumb $crumb) => $crumb->toArray(), 
            $this->getCrumbs()
        );
    }
}