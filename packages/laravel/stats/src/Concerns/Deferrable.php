<?php

declare(strict_types=1);

namespace Honed\Stat\Concerns;

trait Deferrable
{
    /**
     * Set the strategy for deferring the data.
     *
     * @var 'defer'|'lazy'
     */
    protected $defer = 'defer';

    /**
     * Set the strategy for deferring the data.
     *
     * @param  'defer'|'lazy'  $strategy
     * @return $this
     */
    public function defer(string $strategy = 'defer'): static
    {
        $this->defer = $strategy;

        return $this;
    }

    /**
     * Set the strategy for deferring the data to lazy.
     *
     * @return $this
     */
    public function lazy(): static
    {
        return $this->defer('lazy');
    }

    /**
     * Get the strategy for deferring the data.
     */
    public function getDeferStrategy(): string
    {
        return $this->defer;
    }
}
