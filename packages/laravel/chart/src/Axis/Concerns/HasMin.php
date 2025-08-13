<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasMin
{
    /**
     * The minimum value.
     *
     * @var int|string|null
     */
    protected $min;

    /**
     * Set the minimum value.
     *
     * @return $this
     */
    public function min(int|string $value): static
    {
        $this->min = $value;

        return $this;
    }

    /**
     * Get the minimum value.
     */
    public function getMin(): int|string|null
    {
        return $this->min;
    }
}
