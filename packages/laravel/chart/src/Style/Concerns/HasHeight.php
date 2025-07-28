<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasHeight
{
    /**
     * The height.
     * 
     * @var int|null
     */
    protected $height;

    /**
     * Set the height.
     * 
     * @return $this
     */
    public function height(int $value): static
    {
        $this->height = $value;

        return $this;
    }

    /**
     * Get the height.
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }
}