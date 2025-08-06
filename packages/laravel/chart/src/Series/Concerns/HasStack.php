<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

/**
 * @internal
 */
trait HasStack
{
    /**
     * The name of the stack.
     * 
     * @var string|null
     */
    protected $stack;

    /**
     * Set the name of the stack.
     * 
     * @return $this
     */
    public function stack(?string $value): static
    {
        $this->stack = $value;

        return $this;
    }

    /**
     * Get the name of the stack.
     */
    public function getStack(): ?string
    {
        return $this->stack;
    }
}