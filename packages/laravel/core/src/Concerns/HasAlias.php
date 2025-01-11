<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasAlias
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * Set the alias for the instance.
     *
     * @return $this
     */
    public function alias(?string $alias): static
    {
        if (! \is_null($alias)) {
            $this->alias = $alias;
        }

        return $this;
    }

    /**
     * Get the alias for the instance.
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Determine if the instance has an alias set.
     */
    public function hasAlias(): bool
    {
        return isset($this->alias);
    }
}
