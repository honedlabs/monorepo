<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasPrecision
{
    /**
     * @var int|null
     */
    protected $precision = null;

    /**
     * Set the precision, chainable.
     *
     * @return $this
     */
    public function precision(int $precision): static
    {
        $this->setPrecision($precision);

        return $this;
    }

    /**
     * Set the precision quietly.
     */
    public function setPrecision(?int $precision): void
    {
        if (\is_null($precision)) {
            return;
        }

        $this->precision = $precision;
    }

    /**
     * Get the divide by value.
     */
    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    /**
     * Determine if the class has a divide by value.
     */
    public function hasPrecision(): bool
    {
        return ! \is_null($this->precision);
    }
}
