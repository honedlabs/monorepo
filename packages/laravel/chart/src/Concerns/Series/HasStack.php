<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Series;

trait HasStack
{
    protected ?string $stack = null;

    /**
     * Set the stack group name (e.g. ECharts `stack`).
     *
     * @return $this
     */
    public function stack(?string $value): static
    {
        $this->stack = $value;

        return $this;
    }

    public function getStack(): ?string
    {
        return $this->stack;
    }
}
