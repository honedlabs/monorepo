<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Axis;

use Honed\Chart\Enums\AxisType;

/**
 * @phpstan-require-extends \Honed\Chart\Axis
 */
trait HasAxisType
{
    /**
     * The type of the axis.
     *
     * @var ?AxisType
     */
    protected $type;

    /**
     * Set the type of the axis.
     *
     * @return $this
     */
    public function type(AxisType|string $value): static
    {
        $this->type = is_string($value) ? AxisType::from($value) : $value;

        return $this;
    }

    /**
     * Set the type of the axis to be time.
     *
     * @return $this
     */
    public function time(): static
    {
        return $this->type(AxisType::Time);
    }

    /**
     * Set the type of the axis to be log.
     *
     * @return $this
     */
    public function log(): static
    {
        return $this->type(AxisType::Log);
    }

    /**
     * Get the type of the axis.
     */
    public function getType(): ?AxisType
    {
        return $this->type;
    }

    /**
     * Determine if the axis has a type.
     */
    public function hasType(): bool
    {
        return isset($this->type);
    }
}
