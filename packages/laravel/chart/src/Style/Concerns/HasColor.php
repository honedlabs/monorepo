<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasColor
{
    /**
     * The color.
     *
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $color;

    /**
     * Set the color.
     *
     * @return $this
     */
    public function color(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->color = $value;

        return $this;
    }

    /**
     * Set the colour.
     *
     * @return $this
     */
    public function colour(string|Rgb|Rgba|Gradient|null $value): static
    {
        return $this->color($value);
    }

    /**
     * Get the color.
     *
     * @return string|array<string, mixed>|null
     */
    public function getColor(): string|array|null
    {
        return Color::from($this->color);
    }

    /**
     * Get the colour.
     *
     * @return string|array<string, mixed>|null
     */
    public function getColour(): string|array|null
    {
        return $this->getColor();
    }
}
