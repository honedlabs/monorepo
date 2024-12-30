<?php

declare(strict_types=1);

namespace Honed\Core\Identifier\Concerns;

use Honed\Core\Identifier\Identifier;

trait HasId
{
    /**
     * @var int|string|null
     */
    protected $id = null;

    /**
     * Set the ID, chainable.
     *
     * @return $this
     */
    public function id(int|string $id): static
    {
        $this->setId($id);

        return $this;
    }

    /**
     * Set the ID quietly.
     */
    public function setId(int|string|null $id): void
    {
        if (\is_null($id)) {
            return;
        }
        $this->id = $id;
    }

    /**
     * Get the ID.
     */
    public function getId(): int|string|null
    {
        return $this->id ??= $this->generateId();
    }


    /**
     * Determine if the class has an ID.
     */
    public function hasId(): bool
    {
        return ! \is_null($this->id);
    }

    /**
     * Generate a new ID.
     */
    public function generateId(): string
    {
        return Identifier::generate();
    }
}
