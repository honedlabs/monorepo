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
     * Set the attribute for the instance.
     *
     * @return $this
     */
    public function attribute(?string $attribute): static
    {
        if (! \is_null($attribute)) {
            $this->attribute = $attribute;
        }

        return $this;
    }

    /**
     * Get the attribute for the instance.
     */
    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    /**
     * Determine if the instance has an attribute set.
     */
    public function hasAttribute(): bool
    {
        return isset($this->attribute);
    }
}
