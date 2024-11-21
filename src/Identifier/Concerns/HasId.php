<?php

declare(strict_types=1);

namespace Honed\Core\Identifier\Concerns;

use Honed\Core\Identifier\Identifier;

trait HasId
{
    /**
     * @var int|string|(\Closure():int|string)|null
     */
    protected $id = null;

    /**
     * Set the ID, chainable.
     * 
     * @param int|string|(\Closure():int|string) $id
     * @return $this
     */
    public function id(mixed $id): static
    {
        $this->setId($id);

        return $this;
    }

    /**
     * Set the ID quietly.
     * 
     * @param int|string|(\Closure():int|string)|null $id
     */
    public function setId(mixed $id): void
    {
        if (is_null($id)) {
            return;
        }
        $this->id = $id;
    }

    /**
     * Get the ID.
     * 
     * @return int|string|null
     */
    public function getId(): mixed
    {
        $this->setId($this->evaluate($this->id));

        return $this->id ??= $this->generateId();
    }

    /**
     * Determine if the class does not have an ID.
     */
    public function missingId(): bool
    {
        return \is_null($this->id);
    }

    /**
     * Determine if the class has an ID.
     */
    public function hasId(): bool
    {
        return ! $this->missingId();
    }

    /**
     * Generate a new ID.
     * 
     * @return string
     */
    public function generateId(): string
    {
        return $this->id = Identifier::generate();
    }
}
