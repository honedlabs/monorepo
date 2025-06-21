<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait CanHaveViews
{
    /**
     * The table views to utilise.
     * 
     * @var bool|array<int, View>
     */
    protected $views = false;

    /**
     * Set whether the table is viewable, or the specific views you want to use.
     * 
     * @param  bool|View|array<int, View>  $viewable
     * @return $this
     */
    public function viewable($viewable = true)
    {
        $this->views = $viewable;

        return $this;
    }

    /**
     * Determine if the table has views.
     * 
     * @return bool
     */
    public function isViewable()
    {
        return $this->views !== false;
    }
}