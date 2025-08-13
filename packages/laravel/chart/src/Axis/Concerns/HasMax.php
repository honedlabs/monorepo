<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasMax
{
    /**
     * The maximum value.
     *
     * @var int|string|null
     */
    protected $max;

    /**
     * Set the maximum value.
     *
     * @return $this
     */
    public function max(int|string $value): static
    {
        $this->max = $value;

        return $this;
    }

    /**
     * Get the maximum value.
     */
    public function getMax(): int|string|null
    {
        return $this->max;
    }
}
