<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasRounding
{
    /**
     * @var int|(\Closure():int)|null
     */
    protected $rounding = null;

    /**
     * Set the divide by value, chainable.
     *
     * @param int|(\Closure():int) $rounding
     * @return $this
     */
    public function rounding(int|\Closure $rounding): static
    {
        $this->setRounding($rounding);

        return $this;
    }

    /**
     * Set the divide by value quietly.
     *
     * @param int|(\Closure():int)|null $rounding
     */
    public function setRounding(int|\Closure|null $rounding): void
    {
        if (\is_null($rounding)) {
            return;
        }

        $this->rounding = $rounding;
    }

    /**
     * Get the divide by value.
     * 
     * @return int|null
     */
    public function getRounding(): ?int
    {
        return value($this->rounding);
    }

    /**
     * Determine if the class does not have a divide by value.
     * 
     * @return bool
     */
    public function missingRounding(): bool
    {
        return \is_null($this->rounding);
    }

    /**
     * Determine if the class has a divide by value.
     *
     * @return bool
     */
    public function hasRounding(): bool
    {
        return ! $this->missingRounding();
    }
}
