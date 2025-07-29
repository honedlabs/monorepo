<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

use RuntimeException;

trait HasDimension
{
    /**
     * The dimension of the axis.
     * 
     * @var string
     */
    protected $dimension;

    /**
     * Set the dimension of the axis.
     * 
     * @param string $value
     * @return $this
     */
    public function dimension(string $value): static
    {
        $this->dimension = $value;

        return $this;
    }

    /**
     * Get the dimension of the axis.
     * 
     * @return string
     * 
     * @throws \RuntimeException if the dimension is not set
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