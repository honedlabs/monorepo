<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

use Honed\Chart\Enums\AxisPointerType;
use TypeError;
use ValueError;

trait HasAxisPointerType
{
    /**
     * @var AxisPointerType|null
     */
    protected $axisPointerType;

    /**
     * Set how the axis pointer is rendered.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function type(string|AxisPointerType $value): static
    {
        $this->axisPointerType = is_string($value) ? AxisPointerType::from($value) : $value;

        return $this;
    }

    /**
     * Get the axis pointer type.
     */
    public function getAxisPointerType(): ?AxisPointerType
    {
        return $this->axisPointerType;
    }
}
