<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanHavePlaceholder
{
    /**
     * The placeholder.
     */
    protected ?string $placeholder = null;

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
}
