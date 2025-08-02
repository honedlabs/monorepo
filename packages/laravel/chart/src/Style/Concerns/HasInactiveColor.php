<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasInactiveColor
{
    /**
     * The inactive color.
     * 
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $inactiveColor;

    /**
     * Set the inactive color.
     * 
     * @return $this
     */
    public function inactiveColor(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->inactiveColor = $value;

        return $this;
    }

    /**
     * Get the inactive color.
     * 
     * @return string|array<string, mixed>|null
     */
    public function getInactiveColor(): string|array|null
    {
        return Color::from($this->inactiveColor);
    }
}