<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasLineHeight
{
    /**
     * The line height.
     * 
     * @var int|null
     */
    protected $lineHeight;

    /**
     * Set the line height.
     * 
     * @return $this
     */
    public function lineHeight(int $value): static
    {
        $this->lineHeight = $value;

        return $this;
    }

    /**
     * Get the line height.
     */
    public function getLineHeight(): ?int
    {
        return $this->lineHeight;
    }
}