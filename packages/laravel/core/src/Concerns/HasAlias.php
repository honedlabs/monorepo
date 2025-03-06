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
     * Set the alias for the instance.
     *
     * @param  string|null  $alias
     * @return $this
     */
    public function alias($alias)
    {
        if (! \is_null($alias)) {
            $this->alias = $alias;
        }

        return $this;
    }

    /**
     * Get the alias for the instance.
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Determine if the instance has an alias set.
     *
     * @return bool
     */
    public function hasAlias()
    {
        return ! \is_null($this->alias);
    }
}
