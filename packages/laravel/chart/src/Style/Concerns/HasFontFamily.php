<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

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
    public function fontFamily(string $value): static
    {
        $this->fontFamily = $value;

        return $this;
    }

    /**
     * Get the font family.
     */
    public function getFontFamily(): ?string
    {
        return $this->fontFamily;
    }
}