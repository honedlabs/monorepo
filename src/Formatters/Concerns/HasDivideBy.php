<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasDivideBy
{
    /**
     * @var int|(\Closure():int)|null
     */
    protected $divideBy = null;

    /**
     * Set the divide by value, chainable.
     *
     * @param  int|(\Closure():int)  $divideBy
     * @return $this
     */
    public function divideBy(int|\Closure $divideBy): static
    {
        $this->setDivideBy($divideBy);

        return $this;
    }

    /**
     * Set the divide by value quietly.
     *
     * @param  int|(\Closure():int)|null  $divideBy
     */
    public function setDivideBy(int|\Closure|null $divideBy): void
    {
        if (\is_null($divideBy)) {
            return;
        }

        $this->divideBy = $divideBy;
    }

    /**
     * Get the divide by value.
     */
    public function getDivideBy(): ?int
    {
        return value($this->divideBy);
    }

    /**
     * Determine if the class does not have a divide by value.
     */
    public function missingDivideBy(): bool
    {
        return \is_null($this->divideBy);
    }

    /**
     * Determine if the class has a divide by value.
     */
    public function hasDivideBy(): bool
    {
        return ! $this->missingDivideBy();
    }
}
