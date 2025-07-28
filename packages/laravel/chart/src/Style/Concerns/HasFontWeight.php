<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\FontWeight;

trait HasFontWeight
{
    /**
     * The font weight.
     * 
     * @var \Honed\Chart\Enums\FontWeight|int|null
     */
    protected $fontWeight;

    /**
     * Set the font weight.
     * 
     * @return $this
     * 
     * @throws \ValueError if the axis type is not a valid axis type
     */
    public function fontWeight(FontWeight|int|string $value): static
    {
        if (is_string($value)) {
            $value = FontWeight::from($value);
        }

        $this->type = $value;

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
    public function getFontWeight(): ?string
    {
        return $this->type?->value;
    }
}