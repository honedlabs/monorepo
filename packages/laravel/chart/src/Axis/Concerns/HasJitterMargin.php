<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasJitterMargin
{
    /**
     * The minimum distance between two scatters.
     *
     * @var int|null
     */
    protected $jitterMargin;

    /**
     * Set the minimum distance between two scatters.
     *
     * @return $this
     */
    public function jitterMargin(int $value): static
    {
        $this->jitterMargin = $value;

        return $this;
    }

    /**
     * Get the minimum distance between two scatters.
     */
    public function getJitterMargin(): ?int
    {
        return $this->jitterMargin;
    }
}
