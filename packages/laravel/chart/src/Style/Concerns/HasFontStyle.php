<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\FontStyle;

trait HasFontStyle
{
    /**
     * The font style.
     * 
     * @var string|null
     */
    protected $fontStyle;

    /**
     * Set the font style.
     * 
     * @return $this
     */
    public function fontStyle(FontStyle|string $value): static
    {
        if ($value instanceof FontStyle) {
            $value = $value->value;
        }

        $this->fontStyle = $value;

        return $this;
    }

    /**
     * Set the font style to italic.
     * 
     * @return $this
     */
    public function italic(): static
    {
        return $this->fontStyle(FontStyle::Italic);
    }

    /**
     * Set the font style to oblique.
     * 
     * @return $this
     */
    public function oblique(): static
    {
        return $this->fontStyle(FontStyle::Oblique);
    }

    /**
     * Get the font style.
     */
    public function getFontStyle(): ?string
    {
        return $this->fontStyle;
    }
}