<?php

declare(strict_types=1);

namespace Honed\Table\EmptyState\Concerns;

trait HasDescription
{
    /**
     * The description of the empty state.
     * 
     * @var string
     */
    protected $description = 'There are no results to display.';

    /**
     * Set the description of the empty state.
     * 
     * @param  string  $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description of the empty state.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}