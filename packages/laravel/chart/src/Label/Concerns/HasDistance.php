<?php

declare(strict_types=1);

namespace Honed\Chart\Label\Concerns;

trait HasDistance
{
    /**
     * The distance to the host element.
     * 
     * @var int|null
     */
    protected $distance;

    /**
     * Set the distance to the host element.
     * 
     * @return $this
     */
    public function distance(int $value): static
    {
        $this->distance = $value;

        return $this;
    }

    /**
     * Get the distance to the host element.
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }
}