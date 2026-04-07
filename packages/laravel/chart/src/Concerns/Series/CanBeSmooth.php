<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Series;

trait CanBeSmooth
{
    /**
     * Indicates whether to smooth the line.
     *
     * @var ?bool
     */
    protected $smooth;

    /**
     * Set the line to be smooth.
     *
     * @return $this
     */
    public function smooth(bool $value = true): static
    {
        $this->smooth = $value;

        return $this;
    }

    /**
     * Set the line to not be smooth.
     *
     * @return $this
     */
    public function dontSmooth(): static
    {
        return $this->smooth(false);
    }

    /**
     * Determine if the line is smooth.
     */
    public function isSmooth(): ?bool
    {
        return $this->smooth;
    }
}
