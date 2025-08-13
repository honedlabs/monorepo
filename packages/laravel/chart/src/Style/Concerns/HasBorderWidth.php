<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasBorderWidth
{
    /**
     * The width of the border.
     *
     * @var int|null
     */
    protected $borderWidth;

    /**
     * Set the text border width.
     *
     * @return $this
     */
    public function borderWidth(int $value): static
    {
        $this->borderWidth = $value;

        return $this;
    }

    /**
     * Get the text border width.
     */
    public function getBorderWidth(): ?int
    {
        return $this->borderWidth;
    }
}
