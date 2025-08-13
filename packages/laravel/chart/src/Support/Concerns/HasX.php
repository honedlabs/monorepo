<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasX
{
    /**
     * The x position.
     *
     * @var int|string|null
     */
    protected $x;

    /**
     * Set the x.
     *
     * @return $this
     */
    public function x(int|string $value): static
    {
        $this->x = $value;

        return $this;
    }

    /**
     * Get the x.
     */
    public function getX(): int|string|null
    {
        return $this->x;
    }
}
