<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasPadding
{
    /**
     * The padding.
     *
     * @var int|array<int, int>|null
     */
    protected $padding;

    /**
     * Set the color.
     *
     * @param  int|array<int, int>|null  $value
     * @return $this
     */
    public function padding(int|array|null $value): static
    {
        $this->padding = $value;

        return $this;
    }

    /**
     * Get the color.
     *
     * @return int|array<int, int>|null
     */
    public function getPadding(): int|array|null
    {
        return $this->padding;
    }
}
