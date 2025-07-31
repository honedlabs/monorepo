<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasLeft
{
    /**
     * The distance from the left side of the container.
     * 
     * @var int|string|null
     */
    protected $left;

    /**
     * Set the distance from the left side of the container.
     * 
     * @param int|string|null $value
     * @return $this
     */
    public function left(int|string|null $value): static
    {
        $this->left = $value;

        return $this;
    }

    /**
     * Get the distance from the left side of the container.
     * 
     * @return int|string|null
     */
    public function getLeft(): int|string|null
    {
        return $this->left;
    }
}