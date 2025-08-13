<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasY
{
    /**
     * The y position.
     *
     * @var int|string|null
     */
    protected $y;

    /**
     * Set the y.
     *
     * @return $this
     */
    public function y(int|string $value): static
    {
        $this->y = $value;

        return $this;
    }

    /**
     * Get the y.
     */
    public function getY(): int|string|null
    {
        return $this->y;
    }
}
