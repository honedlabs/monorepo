<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

trait HasPlaceholder
{
    /**
     * The placeholder value to display if the entry is null.
     *
     * @var scalar|null
     */
    protected $placeholder;

    /**
     * Set the placeholder value to display.
     *
     * @param  scalar  $value
     * @return $this
     */
    public function placeholder(mixed $value): static
    {
        $this->placeholder = $value;

        return $this;
    }

    /**
     * Get the placeholder value to display.
     *
     * @return scalar|null
     */
    public function getPlaceholder(): mixed
    {
        return $this->placeholder;
    }
}
