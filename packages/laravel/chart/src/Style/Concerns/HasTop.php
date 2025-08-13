<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasTop
{
    /**
     * The distance from the top side of the container.
     *
     * @var int|string|null
     */
    protected $top;

    /**
     * Set the distance from the top side of the container.
     *
     * @return $this
     */
    public function top(int|string|null $value): static
    {
        $this->top = $value;

        return $this;
    }

    /**
     * Get the distance from the top side of the container.
     */
    public function getTop(): int|string|null
    {
        return $this->top;
    }
}
