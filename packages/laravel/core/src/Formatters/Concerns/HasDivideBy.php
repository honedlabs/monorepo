<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasDivideBy
{
    /**
     * @var int|null
     */
    protected $divideBy = null;

    /**
     * Set the divide by value, chainable.
     *
     * @return $this
     */
    public function divideBy(int $divideBy): static
    {
        $this->setDivideBy($divideBy);

        return $this;
    }

    /**
     * Set the divide by value quietly.
     */
    public function setDivideBy(?int $divideBy): void
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
        return $this->divideBy;
    }

    /**
     * Determine if the class has a divide by value.
     */
    public function hasDivideBy(): bool
    {
        return ! \is_null($this->divideBy);
    }
}
