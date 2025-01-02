<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasAlias
{
    /**
     * @var string|null
     */
    protected $alias = null;

    /**
     * Set the alias, chainable.
     *
     * @return $this
     */
    public function alias(string $alias): static
    {
        $this->setAlias($alias);

        return $this;
    }

    /**
     * Set the alias quietly.
     */
    public function setAlias(?string $alias): void
    {
        if (\is_null($alias)) {
            return;
        }

        $this->alias = $alias;
    }

    /**
     * Get the alias.
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Determine if the class has a alias.
     */
    public function hasAlias(): bool
    {
        return ! \is_null($this->alias);
    }
}
