<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\FontFamily;

trait HasFontFamily
{
    /**
     * The font family.
     * 
     * @var string|null
     */
    protected $fontFamily;

    /**
     * Set the font family.
     * 
     * @return $this
     */
    public function fontFamily(string|FontFamily $value): static
    {
        $this->fontFamily = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the font family to be sans-serif.
     * 
     * @return $this
     */
    public function sansSerif(): static
    {
        return $this->fontFamily(FontFamily::SansSerif);
    }

    /**
     * Set the font family to be monospace.
     * 
     * @return $this
     */
    public function monospace(): static
    {
        return $this->fontFamily(FontFamily::Monospace);
    }

    /**
     * Get the font family.
     */
    public function getFontFamily(): ?string
    {
        return $this->fontFamily;
    }
}