<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait IsDifference
{
    /**
     * @var bool
     */
    protected $difference = false;

    /**
     * Set the column as the difference, chainable
     *
     * @return $this
     */
    public function difference(bool $difference = true): static
    {
        $this->setDifference($difference);

        return $this;
    }

    /**
     * Set the difference value quietly.
     */
    public function setDifference(bool $difference): void
    {
        $this->difference = $difference;
    }

    /**
     * Determine if the class is the difference.
     */
    public function isDifference(): bool
    {
        return $this->difference;
    }

    /**
     * Alias for `difference`.
     *
     * @return $this
     */
    public function since(): static
    {
        return $this->difference(true);
    }
}
