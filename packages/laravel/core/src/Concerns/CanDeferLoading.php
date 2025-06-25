<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Inertia\Inertia;

trait CanDeferLoading
{
    /**
     * Defer the loading of the instance.
     *
     * @param  string  $group
     * @return \Inertia\DeferProp
     */
    public function deferLoading($group = 'default')
    {
        return Inertia::defer(fn () => $this->toArray(), $group);
    }

    /**
     * Lazily load the instance.
     *
     * @return \Inertia\LazyProp
     */
    public function lazyLoading()
    {
        return Inertia::lazy(fn () => $this->toArray());
    }
}
