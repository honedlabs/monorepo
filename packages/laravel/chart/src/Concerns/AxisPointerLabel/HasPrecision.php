<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

trait HasPrecision
{
    /**
     * @var int|string|null
     */
    protected $precision;

    /**
     * @return $this
     */
    public function precision(int|string|null $value): static
    {
        $this->precision = $value;

        return $this;
    }

    public function getPrecision(): int|string|null
    {
        return $this->precision;
    }
}
