<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasMaxInterval
{
    /**
     * The maximum interval value.
     *
     * @var int|string|null
     */
    protected $maxInterval;

    /**
     * Set the maximum interval value.
     *
     * @return $this
     */
    public function maxInterval(int|string $value): static
    {
        $this->maxInterval = $value;

        return $this;
    }

    /**
     * Get the maximum interval value.
     */
    public function getMaxInterval(): int|string|null
    {
        return $this->maxInterval;
    }
}
