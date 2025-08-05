<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait HasLength
{
    /**
     * The length.
     * 
     * @var int|null
     */
    protected $length;

    /**
     * Set the length.
     * 
     * @return $this
     */
    public function length(int $value): static
    {
        $this->length = $value;

        return $this;
    }

    /**
     * Get the length.
     */
    public function getLength(): ?int
    {
        return $this->length;
    }
}