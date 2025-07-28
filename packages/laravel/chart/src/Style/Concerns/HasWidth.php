<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasWidth
{
    /**
     * The width.
     * 
     * @var int|null
     */
    protected $width;

    /**
     * Set the width.
     * 
     * @return $this
     */
    public function width(int $value): static
    {
        $this->width = $value;

        return $this;
    }

    /**
     * Get the width.
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }
}