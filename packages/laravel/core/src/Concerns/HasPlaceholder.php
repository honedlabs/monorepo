<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder.
     *
     * @var ?string
     */
    protected $placeholder;

    /**
     * Set the placeholder.
     *
     * @return $this
     */
    public function placeholder(?string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder.
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * Determine if a placeholder is set.
     */
    public function hasPlaceholder(): bool
    {
        return isset($this->placeholder);
    }

    /**
     * Determine if a placeholder is not set.
     */
    public function missingPlaceholder(): bool
    {
        return ! $this->hasPlaceholder();
    }
}
