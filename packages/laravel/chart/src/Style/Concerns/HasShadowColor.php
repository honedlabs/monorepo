<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasShadowColor
{
    /**
     * The color of the shadow.
     *
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $shadowColor;

    /**
     * Set the color of the shadow.
     *
     * @return $this
     */
    public function shadowColor(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->shadowColor = $value;

        return $this;
    }

    /**
     * Get the color of the shadow.
     *
     * @return string|array<string, mixed>|null
     */
    public function getShadowColor(): string|array|null
    {
        return Color::from($this->shadowColor);
    }
}
