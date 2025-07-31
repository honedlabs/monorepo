<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasRight
{
    /**
     * The distance from the right side of the container.
     * 
     * @var int|string|null
     */
    protected $right;

    /**
     * Set the distance from the right side of the container.
     * 
     * @param int|string|null $value
     * @return $this
     */
    public function right(int|string|null $value): static
    {
        $this->right = $value;

        return $this;
    }

    /**
     * Get the distance from the right side of the container.
     * 
     * @return int|string|null
     */
    public function getRight(): int|string|null
    {
        return $this->right;
    }
}