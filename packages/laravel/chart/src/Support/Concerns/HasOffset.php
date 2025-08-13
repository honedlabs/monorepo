<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasOffset
{
    /**
     * The offset to the default position.
     * 
     * @var int|null
     */
    protected $offset;

    /**
     * Set the offset.
     * 
     * @return $this
     */
    public function offset(int $value): static
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * Get the offset.
     */
    public function getOffset(): float|int
    {
        return $this->offset;
    }
}