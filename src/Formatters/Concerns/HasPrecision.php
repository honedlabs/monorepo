<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasPrecision
{
    /**
     * @var int|(\Closure():int)|null
     */
    protected $precision = null;

    /**
     * Set the divide by value, chainable.
     *
     * @param int|(\Closure():int) $precision
     * @return $this
     */
    public function precision(int|\Closure $precision): static
    {
        $this->setPrecision($precision);

        return $this;
    }

    /**
     * Set the divide by value quietly.
     *
     * @param int|(\Closure():int)|null $precision
     */
    public function setPrecision(int|\Closure|null $precision): void
    {
        if (\is_null($precision)) {
            return;
        }

        $this->precision = $precision;
    }

    /**
     * Get the divide by value.
     * 
     * @return int|null
     */
    public function getPrecision(): ?int
    {
        return value($this->precision);
    }

    /**
     * Determine if the class does not have a divide by value.
     * 
     * @return bool
     */
    public function missingPrecision(): bool
    {
        return \is_null($this->precision);
    }

    /**
     * Determine if the class has a divide by value.
     *
     * @return bool
     */
    public function hasPrecision(): bool
    {
        return ! $this->missingPrecision();
    }
}
