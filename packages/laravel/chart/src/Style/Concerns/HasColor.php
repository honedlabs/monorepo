<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasColor
{
    /**
     * The color.
     * 
     * @var string|Rgba|null
     */
    protected $color;

    /**
     * Set the color.
     * 
     * @return $this
     */
    public function color(string|Rgba|null $value): static
    {
        $this->color = $value;

        return $this;
    }

    /**
     * Get the color.
     */
    public function getColor(): ?string
    {
        return Color::from($this->color);
    }
}