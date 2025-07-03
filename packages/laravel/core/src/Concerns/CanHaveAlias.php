<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanHaveAlias
{
    /**
     * The alias to use to hide the underlying value.
     *
     * @var string|null
     */
    protected $alias;

    /**
     * Set the alias.
     *
     * @return $this
     */
    public function alias(?string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Set there to be no alias.
     *
     * @return $this
     */
    public function dontAlias(): static
    {
        return $this->alias(null);
    }

    /**
     * Get the alias.
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }
}
