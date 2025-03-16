<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

trait HasDirection
{
    /**
     * The order direction.
     * 
     * @var 'asc'|'desc'|null
     */
    protected $direction;

    /**
     * Indicate that only a single direction is allowed.
     * 
     * @var 'asc'|'desc'|null
     */
    protected $only;

    /**
     * Whether the direction is inverted.
     * 
     * @var bool
     */
    protected $invert = false;
    
    /**
     * Fix the direction to a single value.
     * 
     * @param  'asc'|'desc'|null  $direction
     * @return $this
     */
    public function only($direction)
    {
        $this->only = $direction;

        return $this;
    }

    /**
     * Fix the direction to be ascending.
     * 
     * @return $this
     */
    public function asc()
    {
        return $this->only('asc');
    }

    /**
     * Fix the direction to be descending.
     * 
     * @return $this
     */
    public function desc()
    {
        return $this->only('desc');
    }

    /**
     * Invert the direction of the sort.
     * 
     * @param bool $invert
     * @return $this
     */
    public function invert($invert = true)
    {
        $this->invert = $invert;

        return $this;
    }

    /**
     * Determine if the direction is inverted.
     * 
     * @return bool
     */
    public function isInverted()
    {
        return $this->invert;
    }
    

    
}