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
     * Get or set the alias for the instance.
     * 
     * @param string|null $alias The alias to set, or null to retrieve the current alias.
     * @return string|null|$this The current alias when no argument is provided, or the instance when setting the alias.
     */
    public function alias($alias = null)
    {
        if (\is_null($alias)) {
            return $this->alias;
        }

        $this->alias = $alias;

        return $this;
    }

    /**
     * Determine if the instance has an alias set.
     * 
     * @return bool True if an alias is set, false otherwise.
     */
    public function hasAlias()
    {
        return ! \is_null($this->alias);
    }
}
