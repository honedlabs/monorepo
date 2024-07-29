<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set whether a class is the blank
 */
trait IsBlank
{
    protected bool|Closure $blank = false;

    /**
     * Set the class as blank, chainable
     */
    public function blank(bool|Closure $blank = true): static
    {
        $this->setBlank($blank);

        return $this;
    }

    /**
     * Set the blank quietly
     */
    public function setBlank(bool|Closure|null $blank): void
    {
        if (is_null($blank)) {
            return;
        }
        $this->blank = $blank;
    }

    /**
     * Check if the class is blank
     */
    public function isBlank(): bool
    {
        return (bool) $this->evaluate($this->blank);
    }

    /**
     * Check if the class is not blank
     */
    public function isNotBlank(): bool
    {
        return ! $this->isBlank();
    }
}
