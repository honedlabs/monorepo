<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait Asynchronous
{
    /**
     * The message to display when the component is pending.
     *
     * @var ?string
     */
    protected $pending;

    /**
     * Set the message to display when the component is pending.
     *
     * @return $this
     */
    public function pending(?string $value): static
    {
        $this->pending = $value;

        return $this;
    }

    /**
     * Get the message to display when the component is pending.
     */
    public function getPending(): ?string
    {
        return $this->pending;
    }
}