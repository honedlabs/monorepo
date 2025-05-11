<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Illuminate\Support\Str;

trait HasColor
{
    /**
     * The color to use.
     * 
     * @var string|array<int,string>|null
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
     * Set the colour to use.
     * 
     * @param string $colour
     * @return $this
     */
    public function colour($colour)
    {
        return $this->color($colour);
    }

    /**
     * Get the color to use.
     * 
     * @return string|null
     */
    public function getColor()
    {
        if (is_null($this->color)) {
            return null;
        }

        if (is_array($this->color)) {
            return array_map($this->normalizeColor(...), $this->color);
        }

        return $this->normalizeColor($this->color);
    }

    /**
     * Get the colour to use.
     * 
     * @return string|null
     */
    public function getColour()
    {
        return $this->getColor();
    }

    /**
     * Normalize the colour to a valid format.
     * 
     * @param string $color
     * @return string
     */
    protected function normalizeColor($color)
    {
        return Str::start($color, '#');
    }

    /**
     * Normalize the colour to a valid format.
     * 
     * @param string $colour
     * @return string
     */
    protected function normalizeColour($colour)
    {
        return $this->normalizeColor($colour);
    }

    /**
     * Get the colour configuration as an array.
     * 
     * @return array<string, mixed>
     */
    public function colorToArray()
    {
        return [
            'color' => $this->getColor()
        ];
    }

    /**
     * Get the colour configuration as an array.
     * 
     * @return array<string, mixed>
     */
    public function colourToArray()
    {
        return $this->colorToArray();
    }
}