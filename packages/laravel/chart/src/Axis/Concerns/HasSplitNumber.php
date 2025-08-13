<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasSplitNumber
{
    /**
     * The number of segments to split into.
     *
     * @var int|null
     */
    protected $splitNumber;

    /**
     * Set the number of segments to split into.
     *
     * @return $this
     */
    public function splitNumber(int $value): static
    {
        $this->splitNumber = $value;

        return $this;
    }

    /**
     * Get the number of segments to split into.
     */
    public function getSplitNumber(): ?int
    {
        return $this->splitNumber;
    }
}
