<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * The type for the instance.
     *
     * @var ?string
     */
    protected $type;

    /**
     * Set the type.
     *
     * @return $this
     */
    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Determine if a type is set.
     */
    public function hasType(): bool
    {
        return isset($this->type);
    }

    /**
     * Determine if a type is not set.
     */
    public function missingType(): bool
    {
        return ! $this->hasType();
    }
}
