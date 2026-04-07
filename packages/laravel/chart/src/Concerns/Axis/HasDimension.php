<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Axis;

use Honed\Chart\Enums\Dimension;

trait HasDimension
{
    /**
     * Set the dimension of the axis.
     *
     * @var Dimension
     */
    protected $dimension;

    /**
     * Set the dimension of the axis.
     *
     * @return $this
     */
    public function dimension(Dimension|string $value): static
    {
        $this->dimension = is_string($value) ? Dimension::from($value) : $value;

        return $this;
    }

    /**
     * Set the dimension of the axis to be x.
     *
     * @return $this
     */
    public function x(): static
    {
        return $this->dimension(Dimension::X);
    }

    /**
     * Set the dimension of the axis to be y.
     *
     * @return $this
     */
    public function y(): static
    {
        return $this->dimension(Dimension::Y);
    }

    /**
     * Get the dimension of the axis.
     */
    public function getDimension(): Dimension
    {
        return $this->dimension;
    }
}
