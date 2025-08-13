<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

use RuntimeException;

trait HasDimension
{
    public const X = 'x';

    public const Y = 'y';

    /**
     * The dimension of the axis.
     *
     * @var string|null
     */
    protected $dimension;

    /**
     * Set the dimension of the axis.
     *
     * @return $this
     */
    public function dimension(string $value): static
    {
        $this->dimension = $value;

        return $this;
    }

    /**
     * Set the dimension of the axis to be x.
     *
     * @return $this
     */
    public function x(): static
    {
        return $this->dimension(self::X);
    }

    /**
     * Set the dimension of the axis to be y.
     *
     * @return $this
     */
    public function y(): static
    {
        return $this->dimension(self::Y);
    }

    /**
     * Get the dimension of the axis.
     *
     *
     * @throws RuntimeException if the dimension is not set
     */
    public function getDimension(): string
    {
        if (! isset($this->dimension)) {
            throw new RuntimeException(
                'You must specify a dimension for the axis ['.static::class.'].'
            );
        }

        return $this->dimension;
    }
}
