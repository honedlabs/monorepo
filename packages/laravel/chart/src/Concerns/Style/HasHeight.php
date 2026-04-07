<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Style;

trait HasHeight
{
    /**
     * The height.
     *
     * @var int|string|null
     */
    protected $height;

    /**
     * Set the height.
     *
     * @return $this
     */
    public function height(int|string $value): static
    {
        $this->height = $value;

        return $this;
    }

    /**
     * Get the height.
     */
    public function getHeight(): int|string|null
    {
        return $this->height;
    }
}
