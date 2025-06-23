<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Facades\Views;
use Honed\Table\PendingViewInteraction;

trait CanHaveViews
{
    /**
     * The table views to utilise.
     *
     * @var bool|array<int, PendingViewInteraction>
     */
    protected $views = false;

    /**
     * Set whether the table is viewable, or the specific views you want to use.
     *
     * @param  mixed|array<int, mixed>  $scope
     * @return $this
     */
    public function viewable($scope = true)
    {
        $this->views = match (true) {
            is_bool($scope) => $scope,
            default => is_array($scope) ? $scope : func_get_args()
        };

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
     *
     * @return PendingViewInteraction|null
     */
    public function getViews()
    {
        return match (true) {
            ! $this->views => null,
            $this->views === true => Views::for(),
            is_array($this->views) => Views::for($this->views),
        };
    }
}
