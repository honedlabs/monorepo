<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\FontWeight;

trait HasFontWeight
{
    /**
     * The font weight.
     * 
     * @var string|int|null
     */
    protected $fontWeight;

    /**
     * Set the font weight.
     * 
     * @return $this
     */
    public function fontWeight(FontWeight|int|string $value): static
    {
        if ($value instanceof FontWeight) {
            $value = $value->value;
        }

        $this->fontWeight = $value;

        return $this;
    }

    /**
     * Set the font weight to bold.
     * 
     * @return $this
     */
    public function bold(): static
    {
        return $this->fontWeight(FontWeight::Bold);
    }

    /**
     * Set the font weight to be bolder.
     * 
     * @return $this
     */
    public function bolder(): static
    {
        return $this->fontWeight(FontWeight::Bolder);
    }

    /**
     * Set the font weight to be lighter.
     * 
     * @return $this
     */
    public function lighter(): static
    {
        return $this->fontWeight(FontWeight::Lighter);
    }

    /**
     * Get the font weight.
     */
    public function getFontWeight(): string|int|null
    {
        return $this->fontWeight;
    }
}