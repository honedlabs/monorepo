<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasJitter
{
    /**
     * The amount of random noise (only for scatter plots).
     *
     * @var int|null
     */
    protected $jitter;

    /**
     * Set the amount of random noise (only for scatter plots).
     *
     * @return $this
     */
    public function jitter(int $value): static
    {
        $this->jitter = $value;

        return $this;
    }

    /**
     * Get the amount of random noise (only for scatter plots).
     */
    public function getJitter(): ?int
    {
        return $this->jitter;
    }
}
