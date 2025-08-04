<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasMinInterval
{
    /**
     * The minimum interval value.
     * 
     * @var int|string|null
     */
    protected $minInterval;

    /**
     * Set the minimum interval value.
     * 
     * @return $this
     */
    public function minInterval(int|string $value): static
    {
        $this->minInterval = $value;

        return $this;
    }

    /**
     * Get the minimum interval value.
     */
    public function getMinInterval(): int|string|null
    {
        return $this->minInterval;
    }
}