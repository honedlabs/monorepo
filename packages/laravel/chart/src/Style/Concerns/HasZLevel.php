<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

/**
 * @internal
 */
trait HasZLevel
{
    /**
     * The z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     *
     * @var int|null
     */
    protected $zLevel;

    /**
     * Set the z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     *
     * @return $this
     */
    public function zLevel(?int $value): static
    {
        $this->zLevel = $value;

        return $this;
    }

    /**
     * Get the z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     */
    public function getZLevel(): ?int
    {
        return $this->zLevel;
    }
}
