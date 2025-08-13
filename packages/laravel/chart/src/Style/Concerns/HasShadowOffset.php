<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasShadowOffset
{
    /**
     * The offset distance on the horizontal direction of the shadow.
     *
     * @var int|null
     */
    protected $shadowOffsetX;

    /**
     * The offset distance on the vertical direction of the shadow.
     *
     * @var int|null
     */
    protected $shadowOffsetY;

    /**
     * Set the offset distance on the horizontal direction of the shadow.
     *
     * @return $this
     */
    public function shadowOffsetX(int $value): static
    {
        $this->shadowOffsetX = $value;

        return $this;
    }

    /**
     * Get the offset distance on the horizontal direction of the shadow.
     */
    public function getShadowOffsetX(): ?int
    {
        return $this->shadowOffsetX;
    }

    /**
     * Set the offset distance on the vertical direction of the shadow.
     *
     * @return $this
     */
    public function shadowOffsetY(int $value): static
    {
        $this->shadowOffsetY = $value;

        return $this;
    }

    /**
     * Get the offset distance on the vertical direction of the shadow.
     */
    public function getShadowOffsetY(): ?int
    {
        return $this->shadowOffsetY;
    }

    /**
     * Set the offset distance on the horizontal and vertical directions of the shadow.
     *
     * @return $this
     */
    public function shadowOffset(int $x, int $y): static
    {
        return $this->shadowOffsetX($x)->shadowOffsetY($y);
    }
}
