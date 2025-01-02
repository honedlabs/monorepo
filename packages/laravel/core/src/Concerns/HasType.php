<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * @var string|null
     */
    protected $type = null;

    /**
     * Set the type property, chainable
     *
     * @return $this
     */
    public function type(string $type): static
    {
        $this->setType($type);

        return $this;
    }

    /**
     * Set the type property quietly.
     */
    public function setType(?string $type): void
    {
        if (\is_null($type)) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Get the type using the given closure dependencies.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Determine if the class has a type.
     */
    public function hasType(): bool
    {
        return ! \is_null($this->type);
    }
}
