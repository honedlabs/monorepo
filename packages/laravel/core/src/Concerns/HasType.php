<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Set the type for the instance.
     *
     * @return $this
     */
    public function type(?string $type): static
    {
        if (! \is_null($type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Get the type for the instance.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Determine if the instance has an type set.
     */
    public function hasType(): bool
    {
        return isset($this->type);
    }
}
