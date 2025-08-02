<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\Overflow;

trait HasOverflow
{
    /**
     * The strategy for displaying text when it overflows.
     * 
     * @var string|null
     */
    protected $overflow;

    /**
     * Set the strategy for displaying text when it overflows.
     * 
     * @return $this
     */
    public function overflow(string|Overflow $value): static
    {
        $this->overflow = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the strategy for displaying text when it overflows to truncate
     * 
     * @return $this
     */
    public function truncate(): static
    {
        return $this->overflow(Overflow::Truncate);
    }

    /**
     * Set the strategy for displaying text when it overflows to be break.
     * 
     * @return $this
     */
    public function break(): static
    {
        return $this->overflow(Overflow::Break);
    }

    /**
     * Set the strategy for displaying text when it overflows to be break-all.
     * 
     * @return $this
     */
    public function breakAll(): static
    {
        return $this->overflow(Overflow::BreakAll);
    }

    /**
     * Get the strategy for displaying text when it overflows.
     */
    public function getOverflow(): ?string
    {
        return $this->overflow;
    }
}