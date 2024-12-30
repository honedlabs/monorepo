<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait Truncates
{
    /**
     * @var int|null
     */
    protected $truncate = null;

    /**
     * Set the truncate amount, chainable.
     *
     * @return $this
     */
    public function truncate(int $truncate): static
    {
        $this->setTruncate($truncate);

        return $this;
    }

    /**
     * Set the truncate amount quietly.
     */
    public function setTruncate(int|null $truncate): void
    {
        if (\is_null($truncate)) {
            return;
        }

        $this->truncate = $truncate;
    }

    /**
     * Get the truncate amount.
     */
    public function getTruncate(): int|null
    {
        return $this->truncate;
    }

    /**
     * Determine if the class has a truncate amount.
     */
    public function hasTruncate(): bool
    {
        return ! \is_null($this->truncate);
    }
}
