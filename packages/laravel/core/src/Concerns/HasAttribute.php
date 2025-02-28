<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasAttribute
{
    /**
     * @var string|null
     */
    protected $attribute;

    /**
     * Set the attribute for the instance.
     *
     * @param  string|null  $attribute
     * @return $this
     */
    public function attribute($attribute)
    {
        if (! \is_null($attribute)) {
            $this->attribute = $attribute;
        }

        return $this;
    }

    /**
     * Get the attribute for the instance.
     *
     * @return string|null
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Determine if the instance has an attribute set.
     *
     * @return bool
     */
    public function hasAttribute()
    {
        return ! \is_null($this->attribute);
    }
}
