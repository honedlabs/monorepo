<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Set the name.
     *
     * @return $this
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Determine if the name is set.
     */
    public function hasName(): bool
    {
        return isset($this->name);
    }

    /**
     * Determine if the name is not set.
     */
    public function missingName(): bool
    {
        return ! $this->hasName();
    }
}
