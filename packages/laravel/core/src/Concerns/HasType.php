<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * The type for the instance.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Set the type.
     *
     * @return $this
     */
    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
