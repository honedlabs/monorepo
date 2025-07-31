<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasRGB
{
    /**
     * The red component of the color.
     * 
     * @var int
     */
    protected $red = 0;

    /**
     * The green component of the color.
     * 
     * @var int
     */
    protected $green = 0;

    /**
     * The blue component of the color.
     * 
     * @var int
     */
    protected $blue = 0;

    /**
     * Set the red component of the color.
     * 
     * @return $this
     */
    public function red(int $red): static
    {
        $this->red = $red;

        return $this;
    }

    /**
     * Get the red component of the color.
     * 
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * Set the green component of the color.
     * 
     * @return $this
     */
    public function green(int $green): static
    {
        $this->green = $green;

        return $this;
    }

    /**
     * Get the green component of the color.
     * 
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * Set the blue component of the color.
     * 
     * @return $this
     */
    public function blue(int $blue): static
    {
        $this->blue = $blue;

        return $this;
    }

    /**
     * Get the blue component of the color.
     * 
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * Set the red, green, and blue components of the color.
     * 
     * @return $this
     */
    public function rgb(int $red = 0, int $green = 0, int $blue = 0): static
    {
        return $this->red($red)
            ->green($green)
            ->blue($blue);
    }
}