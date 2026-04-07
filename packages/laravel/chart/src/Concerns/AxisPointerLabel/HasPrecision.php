<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

trait HasPrecision
{
    /**
     * The precision of the axis pointer label.
     *
     * @var int|string|null
     */
    protected $precision;

    /**
     * Set the precision of the axis pointer label.
     *
     * @return $this
     */
    public function precision(int|string|null $value): static
    {
        $this->precision = $value;

        return $this;
    }

    /**
     * Get the precision of the axis pointer label.
     *
     * @return int|string|null
     */
    public function getPrecision(): int|string|null
    {
        return $this->precision;
    }
}
