<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Series;

trait HasStack
{
    /**
     * The name of the stack group.
     *
     * @var ?string
     */
    protected $stack = null;

    /**
     * Set the name of the stack group.
     *
     * @return $this
     */
    public function stack(?string $value): static
    {
        $this->stack = $value;

        return $this;
    }

    /**
     * Get the name of the stack group.
     */
    public function getStack(): ?string
    {
        return $this->stack;
    }
}
