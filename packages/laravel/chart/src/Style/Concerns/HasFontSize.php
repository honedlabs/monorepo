<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasFontSize
{
    /**
     * The font family.
     *
     * @var int|null
     */
    protected $fontSize;

    /**
     * Set the font family.
     *
     * @return $this
     */
    public function fontSize(int $value): static
    {
        $this->fontSize = $value;

        return $this;
    }

    /**
     * Get the font family.
     */
    public function getFontSize(): ?int
    {
        return $this->fontSize;
    }
}
