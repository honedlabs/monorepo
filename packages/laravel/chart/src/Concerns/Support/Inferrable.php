<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Support;

trait Inferrable
{
    /**
     * Whether to implement inferring logic for the component.
     *
     * @var bool
     */
    protected $infer = false;

    /**
     * Set the component to infer.
     *
     * @return $this
     */
    public function infer(bool $value = true): static
    {
        $this->infer = $value;

        return $this;
    }

    /**
     * Set the component to not infer.
     */
    public function dontinfer(): static
    {
        return $this->infer(false);
    }

    /**
     * Determine if the component infers.
     */
    public function infers(): bool
    {
        return $this->infer;
    }
}
