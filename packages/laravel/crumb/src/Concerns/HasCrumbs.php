<?php

declare(strict_types=1);

namespace Honed\Crumb\Concerns;

use Honed\Crumb\Crumb;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Collection\Collection;

trait HasCrumbs
{
    /**
     * List of the crumbs.
     *
     * @var array<int,\Honed\Crumb\Crumb>
     */
    protected $crumbs = [];

    /**
     * Merge a set of crumbs with existing.
     *
     * @param  array<int,\Honed\Crumb\Trail>|\Illuminate\Support\Collection<int,\Honed\Crumb\Trail>  $crumbs
     * @return $this
     */
    public function crumbs($crumbs)
    {
        if ($crumbs instanceof Collection) {
            $crumbs = $crumbs->all();
        }

        $this->crumbs = \array_merge($this->crumbs, $crumbs);

        return $this;
    }

    /**
     * Add a single crumb to the list of crumbs.
     *
     * @param \Honed\Crumb\Crumb $crumb
     * @return $this
     */
    public function addCrumb(Crumb $crumb)
    {
        $this->crumbs[] = $crumb;

        return $this;
    }

    /**
     * Retrieve the crumbs
     *
     * @return array<int,\Honed\Crumb\Crumb>
     */
    public function getCrumbs()
    {
        return $this->crumbs;
    }

    /**
     * Determine if the instance has crumbs.
     * 
     * @return bool
     */
    public function hasCrumbs()
    {
        return filled($this->getCrumbs());
    }

    /**
     * Get the crumbs as an array.
     *
     * @return array<int,mixed>
     */
    public function crumbsToArray()
    {
        return \array_map(
            static fn (Crumb $crumb) => $crumb->toArray(),
            $this->getCrumbs()
        );
    }
}
