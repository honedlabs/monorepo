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
     * 
     * @return bool
     */
    public function isDifference(): bool
    {
        return (bool) value($this->difference);
    }

    /**
     * Determine if the class is not the difference.
     * 
     * @return bool
     */
    public function isNotDifference(): bool
    {
        return ! $this->isDifference();
    }
}
