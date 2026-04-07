<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

use Honed\Chart\Enums\AxisPointerType;

trait HasAxisPointerType
{
    /**
     * @var AxisPointerType|null
     */
    protected $axisPointerType;

    /**
     * @return $this
     */
    public function type(string|AxisPointerType $value): static
    {
        $this->axisPointerType = is_string($value) ? AxisPointerType::from($value) : $value;

        return $this;
    }

    public function getAxisPointerType(): ?AxisPointerType
    {
        return $this->axisPointerType;
    }
}
