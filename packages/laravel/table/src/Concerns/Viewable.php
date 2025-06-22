<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait CanHaveViews
{
    /**
     * The table views to utilise.
     *
     * @var bool|array<int, mixed>
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

    /**
     * Get the views for the table.
     */
    public function getViews()
    {
        if (! $this->views) {
            return null;
        }

    }

    // ->viewable(Auth::user(), AppSession::organisation())

    // Gets the views it needs to
}
