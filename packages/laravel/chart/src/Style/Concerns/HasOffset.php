<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use InvalidArgumentException;

trait HasOffset
{
    /**
     * The offset.
     *
     * @var float|int
     */
    protected $offset = 0;

    /**
     * Set the offset.
     *
     * @return $this
     *
     * @throws InvalidArgumentException if the offset is not between 0 and 1
     */
    public function offset(float|int $value): static
    {
        if ($value < 0 || $value > 1) {
            throw new InvalidArgumentException(
                'Offset must be between 0 and 1.'
            );
        }

        $this->offset = $value;

        return $this;
    }

    /**
     * Set the offset to be 0.
     *
     * @return $this
     */
    public function start(): static
    {
        return $this->offset(0);
    }

    /**
     * Set the offset to be 1.
     *
     * @return $this
     */
    public function end(): static
    {
        return $this->offset(1);
    }

    /**
     * Get the offset.
     */
    public function getOffset(): float|int
    {
        return $this->offset;
    }
}
