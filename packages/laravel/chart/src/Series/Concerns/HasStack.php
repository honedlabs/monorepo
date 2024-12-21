<?php

namespace Conquest\Chart\Series\Concerns;

trait HasStack
{
    protected ?string $stack = null;

    public function stack(string $stack = 'default'): self
    {
        $this->setStack($stack);

        return $this;
    }

    public function setStack(?string $stack): void
    {
        if (is_null($stack)) {
            return;
        }
        $this->stack = $stack;
    }

    public function getStack(): ?string
    {
        return $this->stack;
    }

    public function lacksStack(): bool
    {
        return is_null($this->stack);
    }

    public function hasStack(): bool
    {
        return ! $this->lacksStack();
    }

    public function getStackOption(): array
    {
        return $this->hasStack() ? [
            'stack' => $this->getStack(),
        ] : [];
    }
}
