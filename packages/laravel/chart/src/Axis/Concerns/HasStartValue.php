<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasStartValue
{
    /**
     * The start value of the axis.
     *
     * @var int|null
     */
    protected $startValue;

    /**
     * Set the minimum value.
     *
     * @return $this
     */
    public function startValue(int $value): static
    {
        $this->startValue = $value;

        return $this;
    }

    /**
     * Get the minimum value.
     */
    public function getStartValue(): ?int
    {
        return $this->startValue;
    }
}
