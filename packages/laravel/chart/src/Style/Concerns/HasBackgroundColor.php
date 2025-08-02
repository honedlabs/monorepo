<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

/**
 * @internal
 */
trait HasBackgroundColor
{
    /**
     * The background color.
     * 
     * @var string|Rgb|Rgba|Gradient|null
     */
    protected $backgroundColor;

    /**
     * Set the color.
     * 
     * @return $this
     */
    public function backgroundColor(string|Rgb|Rgba|Gradient|null $value): static
    {
        $this->backgroundColor = $value;

        return $this;
    }

    /**
     * Get the color.
     * 
     * @return string|array<string, mixed>|null
     */
    public function getBackgroundColor(): string|array|null
    {
        return Color::from($this->backgroundColor);
    }
}