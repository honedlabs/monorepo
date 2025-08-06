<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

use Honed\Chart\Enums\AxisType;

trait HasAxisType
{
    /**
     * The type of axis.
     * 
     * @var string|null
     */
    protected $type;

    /**
     * Set the type of axis.
     * 
     * @return $this
     */
    public function type(string|AxisType $value): static
    {
        $this->type = is_string($value) ? $value : $value->value;

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
        return $this->type ?? AxisType::Value->value;
    }
}