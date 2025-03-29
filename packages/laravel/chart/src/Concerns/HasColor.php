<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasColor
{
    /**
     * The color to use.
     * 
     * @var string|null
     */
    protected $color;

    /**
     * Set the color to use.
     * 
     * @param string $color
     * @return $this
     */
    public function color($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the color to use.
     * 
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the color to use.
     * 
     * @param string $color
     * @return $this
     */
    public function colour($color)
    {
        return $this->color($color);
    }

    /**
     * Get the color to use.
     * 
     * @return string|null
     */
    public function getColour()
    {
        return $this->getColor();
    }
}