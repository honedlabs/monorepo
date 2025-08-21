<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait HasHint
{
    /**
     * The hint to display.
     *
     * @var string|null
     */
    protected $hint;

    /**
     * Set the hint to display.
     *
     * @return $this
     */
    public function hint(string $value): static
    {
        $this->hint = $value;

        return $this;
    }

    /**
     * Get the hint to display.
     */
    public function getHint(): ?string
    {
        return $this->hint;
    }
}
