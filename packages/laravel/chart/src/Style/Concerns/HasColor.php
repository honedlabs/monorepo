<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasFontColor
{
    /**
     * The color.
     * 
     * @var string|null
     */
    protected $color;

    /**
     * Set the color.
     * 
     * @return $this
     */
    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the color.
     */
    public function getColor(): ?string
    {
        return $this->color;
    }
}