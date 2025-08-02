<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasInactiveBorderColor
{
    /**
     * The inactive border color.
     * 
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $inactiveBorderColor;

    /**
     * Set the color.
     * 
     * @return $this
     */
    public function inactiveBorderColor(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->inactiveBorderColor = $value;

        return $this;
    }

    /**
     * Get the color.
     * 
     * @return string|array<string, mixed>|null
     */
    public function getInactiveBorderColor(): string|array|null
    {
        return Color::from($this->inactiveBorderColor);
    }
}