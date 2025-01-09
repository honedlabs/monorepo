<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasAttribute
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * Get or set the attribute for the instance.
     * 
     * @param string|null $attribute The attribute to set, or null to retrieve the current attribute.
     * @return string|null|$this The current attribute when no argument is provided, or the instance when setting the attribute.
     */
    public function attribute($attribute = null)
    {
        if (\is_null($attribute)) {
            return $this->attribute;
        }

        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Determine if the instance has an attribute set.
     * 
     * @return bool True if an attribute is set, false otherwise.
     */
    public function hasAttribute()
    {
        return ! \is_null($this->attribute);
    }
}
