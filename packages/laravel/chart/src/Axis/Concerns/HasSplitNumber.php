<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasSplitNumber
{
    /**
     * The minimum value.
     * 
     * @var int|string|null
     */
    protected $splitNumber;

    /**
     * Set the minimum value.
     * 
     * @return $this
     */
    public function splitNumber(int|string $value): static
    {
        $this->splitNumber = $value;

        return $this;
    }

    /**
     * Get the minimum value.
     */
    public function getSplitNumber(): int|string|null
    {
        return $this->splitNumber;
    }
}