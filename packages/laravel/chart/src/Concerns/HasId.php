<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasId
{
    /**
     * The id of the component.
     * 
     * @var string|null
     */
    protected $id;

    /**
     * Set the id of the component.
     */
    public function id(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the id of the component.
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}