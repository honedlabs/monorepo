<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait IsDifference
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $difference = false;

    /**
     * Set the column as the difference, chainable
     *
     * @param  bool|(\Closure():bool)  $difference
     * @return $this
     */
    public function difference(bool|\Closure $difference = true): static
    {
        $this->setDifference($difference);

        return $this;
    }

    /**
     * Set the difference value quietly
     *
     * @param  bool|(\Closure():bool)|null  $difference
     */
    public function setDifference(bool|\Closure|null $difference): void
    {
        if (\is_null($difference)) {
            return;
        }

        $this->difference = $difference;
    }

    /**
     * Determine if the class is the difference.
     */
    public function isDifference(): bool
    {
        return (bool) value($this->difference);
    }

    /**
     * Determine if the class is not the difference.
     */
    public function isNotDifference(): bool
    {
        return ! $this->isDifference();
    }

    /**
     * Alias for difference
     *
     * @return $this
     */
    public function since(): static
    {
        return $this->difference(true);
    }

    /**
     * Alias for difference
     *
     * @return $this
     */
    public function diff(): static
    {
        return $this->difference(false);
    }
}
