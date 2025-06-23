<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\PendingViewInteraction;

trait CanHaveViews
{
    /**
     * The table views to utilise.
     *
     * @var array<int, PendingViewInteraction>
     */
    protected $views = false;

    /**
     * Set whether the table is viewable, or the specific views you want to use.
     *
     * @param  bool|array<int, mixed>  $scopes
     * @return $this
     */
    public function viewable($scopes = true)
    {
        // PendingViewInteraction
        $this->views = $scopes;

        return $this;
    }

    /**
     * Determine if the table has views.
     *
     * @return bool
     */
    public function isViewable()
    {
        return (bool) $this->views;
    }
}
