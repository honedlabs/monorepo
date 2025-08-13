<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

use Honed\Chart\Enums\Align;

trait CanBeAligned
{
    /**
     * The horizontal alignment.
     *
     * @var string|null
     */
    protected $align;

    /**
     * Set the horizontal alignment.
     *
     * @return $this
     */
    public function align(string|Align $value): static
    {
        $this->align = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the horizontal alignment to left.
     *
     * @return $this
     */
    public function alignLeft(): static
    {
        return $this->align(Align::Left);
    }

    /**
     * Set the horizontal alignment to center.
     *
     * @return $this
     */
    public function alignCenter(): static
    {
        return $this->align(Align::Center);
    }

    /**
     * Set the horizontal alignment to right.
     *
     * @return $this
     */
    public function alignRight(): static
    {
        return $this->align(Align::Right);
    }

    /**
     * Get the horizontal alignment.
     */
    public function getAlign(): ?string
    {
        return $this->align;
    }
}
