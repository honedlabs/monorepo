<?php

declare(strict_types=1);

namespace Honed\Refine\Sorts\Concerns;

trait HasDirection
{
    public const ASCENDING = 'asc';

    public const DESCENDING = 'desc';

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
        return $this->direction === self::ASCENDING;
    }

    /**
     * Determine if the direction is descending.
     *
     * @return bool
     */
    public function isDescending()
    {
        return $this->direction === self::DESCENDING;
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
        return $this->fixed(self::ASCENDING);
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
        return $this->fixed(self::DESCENDING);
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
     * @param  'asc'|'desc'|null  $direction
     * @return bool
     */
    public function isFixed($direction = null)
    {
        if ($direction) {
            return $this->fixed === $direction;
        }

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
     * Determine if the direction is fixed to be ascending.
     *
     * @return bool
     */
    protected function isFixedAscending()
    {
        return $this->fixed === self::ASCENDING;
    }

    /**
     * Determine if the direction is fixed to be descending.
     *
     * @return bool
     */
    protected function isFixedDescending()
    {
        return $this->fixed === self::DESCENDING;
    }
}
