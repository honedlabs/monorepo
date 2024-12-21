<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait Truncates
{
    /**
     * @var int|(\Closure():int)|null
     */
    protected $truncate = null;

    /**
     * Set the truncate amount, chainable.
     *
     * @param  int|(\Closure():int)  $truncate
     * @return $this
     */
    public function truncate(int|\Closure $truncate): static
    {
        $this->setTruncate($truncate);

        return $this;
    }

    /**
     * Set the truncate amount quietly.
     *
     * @param  int|(\Closure():int)|null  $truncate
     */
    public function setTruncate(int|\Closure|null $truncate): void
    {
        if (\is_null($truncate)) {
            return;
        }

        $this->truncate = $truncate;
    }

    /**
     * Get the truncate amount.
     */
    public function getTruncate(): ?int
    {
        return value($this->truncate);
    }

    /**
     * Determine if the class does not have a truncate amount.
     */
    public function missingTruncate(): bool
    {
        return \is_null($this->truncate);
    }

    /**
     * Determine if the class has a truncate amount.
     */
    public function hasTruncate(): bool
    {
        return ! $this->missingTruncate();
    }
}
