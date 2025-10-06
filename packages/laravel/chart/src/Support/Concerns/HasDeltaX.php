<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasDeltaX
{
    /**
     * The pixel offset in the x direction.
     *
     * @var int|null
     */
    protected $dx;

    /**
     * Set the pixel offset in the x direction.
     *
     * @return $this
     */
    public function dx(int $value): static
    {
        $this->dx = $value;

        return $this;
    }

    /**
     * Get the pixel offset in the x direction.
     */
    public function getDeltaX(): ?int
    {
        return $this->dx;
    }
}
