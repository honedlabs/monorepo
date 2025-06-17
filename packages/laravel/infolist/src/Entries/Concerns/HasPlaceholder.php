<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder value to display if the entry is null.
     */
    protected mixed $placeholder = null;

    /**
     * Set the placeholder value to display.
     *
     * @return $this
     */
    public function placeholder(mixed $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder value to display.
     */
    public function getPlaceholder(): mixed
    {
        return $this->placeholder;
    }
}
