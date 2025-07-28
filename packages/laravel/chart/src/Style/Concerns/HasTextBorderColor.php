<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasFontTextBorderColor
{
    /**
     * The text border color.
     * 
     * @var string|null
     */
    protected $textBorderColor;

    /**
     * Set the text border color.
     * 
     * @return $this
     */
    public function textBorderColor(?string $textBorderColor): static
    {
        $this->textBorderColor = $textBorderColor;

        return $this;
    }

    /**
     * Get the text border color.
     */
    public function getTextBorderColor(): ?string
    {
        return $this->textBorderColor;
    }
}