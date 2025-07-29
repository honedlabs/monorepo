<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

use Honed\Chart\Enums\AxisType;

trait HasAxisType
{
    /**
     * The type of axis.
     * 
     * @var \Honed\Chart\Enums\AxisType|null
     */
    protected $type;

    /**
     * Set the type of axis.
     * 
     * @return $this
     * 
     * @throws \ValueError if the axis type is not a valid axis type
     */
    public function type(AxisType|string $value): static
    {
        if (! $value instanceof AxisType) {
            $value = AxisType::from($value);
        }

        $this->type = $value;

        return $this;
    }

    /**
     * Set the type of axis to value.
     * 
     * @return $this
     */
    public function value(): static
    {
        return $this->type(AxisType::Value);
    }

    /**
     * Set the type of axis to category.
     * 
     * @return $this
     */
    public function category(): static
    {
        return $this->type(AxisType::Category);
    }

    /**
     * Set the type of axis to time.
     * 
     * @return $this
     */
    public function time(): static
    {
        return $this->type(AxisType::Time);
    }

    /**
     * Get the type of axis.
     */
    public function getType(): string
    {
        return $this->type?->value ?? AxisType::Value->value;
    }
}