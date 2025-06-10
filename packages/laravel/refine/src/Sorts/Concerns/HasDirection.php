<?php

declare(strict_types=1);

namespace Honed\Refine\Sorts\Concerns;

trait HasDirection
{
    /**
     * The order direction.
     *
     * @var 'asc'|'desc'|null
     */
    protected $direction;

    /**
     * Indicate that the direction is fixed.
     *
     * @var 'asc'|'desc'|null
     */
    protected $fixed;

    /**
     * Whether the direction is inverted.
     *
     * @var bool
     */
    protected $invert = false;

    /**
     * Set the direction.
     *
     * @param  'asc'|'desc'|null  $direction
     * @return $this
     */
    public function direction($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get the direction.
     *
     * @return 'asc'|'desc'|null
     */
    public function getDirection()
    {
        return $this->isFixed() ? $this->fixed : $this->direction;
    }

    /**
     * Determine if the direction is ascending.
     *
     * @return bool
     */
    public function isAscending()
    {
        return $this->direction === 'asc';
    }

    /**
     * Determine if the direction is descending.
     *
     * @return bool
     */
    public function isDescending()
    {
        return $this->direction === 'desc';
    }

    /**
     * Fix the direction to a single value.
     *
     * @param  'asc'|'desc'|null  $direction
     * @return $this
     */
    public function fixed($direction)
    {
        $this->fixed = $direction;

        return $this;
    }

    /**
     * Fix the direction to be ascending.
     * 
     * @return $this
     */
    public function ascending()
    {
        return $this->fixed('asc');
    }

    /**
     * Fix the direction to be ascending.
     *
     * @return $this
     */
    public function asc()
    {
        return $this->ascending();
    }

    /**
     * Fix the direction to be descending.
     *
     * @return $this
     */
    public function descending()
    {
        return $this->fixed('desc');
    }

    /**
     * Fix the direction to be descending.
     *
     * @return $this
     */
    public function desc()
    {
        return $this->descending();
    }

    /**
     * Determine if the direction is fixed.
     *
     * @return bool
     */
    public function isFixed()
    {
        return isset($this->fixed);
    }

    /**
     * Invert the direction of the sort.
     *
     * @param  bool  $invert
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

    /**
     * Get the value for the sort indicating an ascending direction.
     *
     * @return string
     */
    public function getAscendingValue()
    {
        return $this->getParameter();
    }

    /**
     * Get the value for the sort indicating a descending direction.
     *
     * @return string
     */
    public function getDescendingValue()
    {
        $parameter = $this->getParameter();

        if ($this->isFixed()) {
            return $parameter;
        }

        return sprintf('-%s', $parameter);
    }

    /**
     * Get the next value to use for the query parameter.
     *
     * @return string|null
     */
    public function getNextDirection()
    {
        $ascending = $this->getAscendingValue();
        $descending = $this->getDescendingValue();

        if ($this->isFixed()) {
            return $this->fixed === 'desc'
                ? $ascending
                : $descending;
        }

        $inverted = $this->isInverted();

        return match (true) {
            $this->isAscending() => $inverted ? null : $descending,
            $this->isDescending() => $inverted ? $ascending : null,
            default => $inverted ? $descending : $ascending,
        };
    }

}