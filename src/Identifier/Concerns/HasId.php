<?php

declare(strict_types=1);

namespace Conquest\Core\Identifier\Concerns;

use Closure;
use Conquest\Core\Identifier\Identifier;

trait HasId
{
    protected mixed $id = null;

    public function id(int|string|Closure $id): static
    {
        $this->setId($id);

        return $this;
    }

    public function setId(int|string|Closure|null $id): void
    {
        if (is_null($id)) {
            return;
        }
        $this->id = $id;
    }

    public function getId(): mixed
    {
        $this->setId($this->evaluate($this->id));

        return $this->id ??= $this->generateId();
    }

    public function hasId(): bool
    {
        return ! is_null($this->id);
    }

    public function lacksId(): bool
    {
        return ! $this->hasId();
    }

    public function generateId(): string
    {
        return $this->id = Identifier::generate();
    }
}
