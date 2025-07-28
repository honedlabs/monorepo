<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasTextBorderWidth
{
    /**
     * The text border width.
     * 
     * @var int|null
     */
    protected $textBorderWidth;

    /**
     * Set the text border width.
     * 
     * @return $this
     */
    public function textBorderWidth(?int $value): static
    {
        $this->textBorderWidth = $value;

        return $this;
    }

    /**
     * Get the text border width.
     */
    public function getTextBorderWidth(): ?int
    {
        return $this->textBorderWidth;
    }
}