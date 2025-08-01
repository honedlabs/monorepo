<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;

trait HasFontTextBorderColor
{
    /**
     * The text border color.
     * 
     * @var string|Rgba|null
     */
    protected $textBorderColor;

    /**
     * Set the text border color.
     * 
     * @return $this
     */
    public function textBorderColor(string|Rgba|null $value): static
    {
        $this->textBorderColor = $value;

        return $this;
    }

    /**
     * Get the text border color.
     */
    public function getTextBorderColor(): ?string
    {
        return Color::from($this->textBorderColor);
    }
}