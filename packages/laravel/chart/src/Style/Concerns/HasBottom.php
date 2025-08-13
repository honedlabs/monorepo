<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasBottom
{
    /**
     * The distance from the bottom side of the container.
     *
     * @var int|string|null
     */
    protected $bottom;

    /**
     * Set the distance from the bottom side of the container.
     *
     * @return $this
     */
    public function bottom(int|string|null $value): static
    {
        $this->bottom = $value;

        return $this;
    }

    /**
     * Get the distance from the bottom side of the container.
     */
    public function getBottom(): int|string|null
    {
        return $this->bottom;
    }
}
