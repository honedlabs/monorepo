<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

trait HasState
{
    /**
     * The state of the column.
     * 
     * @var string|\Closure|null
     */
    protected $state;

    /**
     * Set the state of the column.
     * 
     * @param string|\Closure $state
     * @return $this
     */
    public function state($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the state of the column.
     * 
     * @return string|null
     */
    public function getState()
    {
        return $this->evaluate($this->state);
    }
}