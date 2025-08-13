<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasLogBase
{
    /**
     * The base of the logarithm.
     *
     * @var int|null
     */
    protected $logBase;

    /**
     * Set the base of the logarithm.
     *
     * @return $this
     */
    public function logBase(int $value): static
    {
        $this->logBase = $value;

        return $this;
    }

    /**
     * Get the base of the logarithm.
     */
    public function getLogBase(): ?int
    {
        return $this->logBase;
    }
}
