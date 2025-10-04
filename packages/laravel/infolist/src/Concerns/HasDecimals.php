<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

trait HasDecimals
{
    /**
     * The number of decimal places to display.
     *
     * @var int|null
     */
    protected $decimals;

    /**
     * Set the number of decimal places to display.
     *
     * @return $this
     */
    public function decimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get the number of decimal places to display.
     */
    public function getDecimals(): ?int
    {
        return $this->decimals;
    }
}
