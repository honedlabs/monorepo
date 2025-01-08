<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * @var string|null
     */
    protected $type = null;

    /**
     * Get or set the type for the instance.
     * 
     * @param string|null $type The type to set, or null to retrieve the current type.
     * @return string|null|$this The current type when no argument is provided, or the instance when setting the type.
     */
    public function type($type = null)
    {
        if (\is_null($type)) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Determine if the instance has an type set.
     * 
     * @return bool True if an type is set, false otherwise.
     */
    public function hasType()
    {
        return ! \is_null($this->type);
    }
}
