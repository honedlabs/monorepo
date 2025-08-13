<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasBorderColor
{
    /**
     * The color of the border.
     *
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $borderColor;

    /**
     * Set the color of the border.
     *
     * @return $this
     */
    public function borderColor(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->borderColor = $value;

        return $this;
    }

    /**
     * Get the color of the border.
     *
     * @return string|array<string, mixed>|null
     */
    public function getBorderColor(): string|array|null
    {
        return Color::from($this->borderColor);
    }
}
