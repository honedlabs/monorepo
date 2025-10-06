<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

use Honed\Chart\Enums\VerticalAlign;

trait CanBeVerticallyAligned
{
    /**
     * The vertical alignment.
     *
     * @var string|null
     */
    protected $verticalAlign;

    /**
     * Set the vertical alignment.
     *
     * @return $this
     */
    public function verticalAlign(string|VerticalAlign $value): static
    {
        $this->verticalAlign = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the vertical alignment to left.
     *
     * @return $this
     */
    public function alignTop(): static
    {
        return $this->verticalAlign(VerticalAlign::Top);
    }

    /**
     * Set the vertical alignment to center.
     *
     * @return $this
     */
    public function alignMiddle(): static
    {
        return $this->verticalAlign(VerticalAlign::Middle);
    }

    /**
     * Set the vertical alignment to right.
     *
     * @return $this
     */
    public function alignBottom(): static
    {
        return $this->verticalAlign(VerticalAlign::Bottom);
    }

    /**
     * Get the vertical alignment.
     */
    public function getVerticalAlign(): ?string
    {
        return $this->verticalAlign;
    }
}
