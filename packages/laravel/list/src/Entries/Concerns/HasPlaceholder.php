<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder value to display if the entry is null.
     * 
     * @var mixed
     */
    protected mixed $placeholder;

    /**
     * Set the placeholder value to display.
     * 
     * @param  mixed  $placeholder
     * @return $this
     */
    public function placeholder(mixed $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder value to display.
     * 
     * @return mixed
     */
    public function getPlaceholder(): mixed
    {
        return $this->placeholder;
    }

    /**
     * Determine if a placeholder is set.
     * 
     * @return bool
     */
    public function hasPlaceholder(): bool
    {
        return isset($this->placeholder);
    }
}