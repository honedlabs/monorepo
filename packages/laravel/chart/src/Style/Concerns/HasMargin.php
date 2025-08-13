<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasMargin
{
    /**
     * The margin.
     *
     * @var int|null
     */
    protected $margin;

    /**
     * Set the margin.
     *
     * @return $this
     */
    public function margin(int $value): static
    {
        $this->margin = $value;

        return $this;
    }

    /**
     * Get the margin.
     */
    public function getMargin(): ?int
    {
        return $this->margin;
    }
}
