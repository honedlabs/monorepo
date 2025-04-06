<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasAlias
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
     * @param  string|null  $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Define the alias.
     *
     * @return string|null
     */
    public function defineAlias()
    {
        return null;
    }

    /**
     * Get the alias.
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias ??= $this->defineAlias();
    }

    /**
     * Determine if an alias is set.
     *
     * @return bool
     */
    public function hasAlias()
    {
        return isset($this->getAlias());
    }
}
